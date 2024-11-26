<?php

namespace App\Services;

use Exception;
use App\Enums\CartState;
use App\Helpers\APIResponse;
use App\Helpers\NumberFormat;
use App\Models\Cart;
use App\Traits\DiscountTrait;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Services\Interfaces\ConfigServiceInterface;

class CartService implements CartServiceInterface
{
    use DiscountTrait;


    public function __construct(
        protected CartRepositoryInterface $cartRepository,
        protected CourseRepositoryInterface $courseRepository,
        protected CouponRepositoryInterface $couponRepository,
        protected OrderRepositoryInterface $orderRepository,
        protected ConfigServiceInterface $configService,
    ) {
    }

    public function list()
    {
        try {
            $carts = $this->cartRepository->listCart();
            $courses = [];
            if ($carts->count()) {
                foreach ($carts as $cart) {
                    $course = $this->courseRepository->find($cart->course_id);
                    if ($course['success']) {
                        $course = $course['course'];
                        $course['id'] = $cart->id; #use cart_id
                        $course['fake_cost'] = NumberFormat::VND($course['fake_cost']);
                        $course['cost'] = NumberFormat::VND($course['cost']);
                        $courses[] = $course;
                    } else {
                        $this->cartRepository->removeFromCart($cart->id);
                    }
                }
                if (count($courses)) {
                    return APIResponse::make(true, 'success', '', $courses);
                }
            }
            return APIResponse::make(true, 'info', '');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return APIResponse::make(false, 'error', 'Lỗi server');
        }
    }

    public function add($courseId)
    {
        try {
            if ($this->courseRepository->check($courseId)) {
                $cart = $this->cartRepository->findByCourseId($courseId);
                if ($cart) {
                    switch ($cart->state) {
                        case CartState::PENDING:
                            return APIResponse::make(true, 'info', 'Khóa học đã có trong giỏ hàng.');
                        case CartState::REMOVED:
                            $cart->state = CartState::PENDING;
                            $cart->save();
                            return APIResponse::make(true, 'success', 'Đã thêm khóa học vào giỏ hàng.');
                        case CartState::PURCHASED:
                            return APIResponse::make(true, 'info', 'Bạn đã mua khóa học này.');
                        default:
                            break;
                    }
                } else {
                    $newCart = $this->cartRepository->addToCart($courseId);
                    if ($newCart) {
                        return APIResponse::make(true, 'success', 'Đã thêm khóa học vào giỏ hàng.');
                    } else {
                        return APIResponse::make(false, 'error', 'Vui lòng thử lại sau.');
                    }
                }
            } else {
                return APIResponse::make(false, 'error', 'Khóa học không tồn tại.');
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
    }

    public function summary($data)
    {
        try {
            $ids = $data->ids ?? [];
            $ids = array_unique($ids);
            $codes = $data->codes ?? [];
            $codes = array_unique($codes);
            $basePrice = 0;
            $totalPrice = 0;
            $discount = 0;
            $coupons = [];
            $message = '';
            $count = 0;
            if (!empty($ids)) {
                list($basePrice, $totalPrice) = $this->makeTotalCarts($ids);

                $coupons = [
                    'data' => $this->findValidCouponsByCost($totalPrice) ?? [],
                    'limit' => false
                ];
            }

            if (!empty($codes)) {
                $codes = array_combine($codes, $codes);
                $previousReduce = null;
                foreach ($codes as $code => $value) {
                    $reduce = $this->makeDiscountCost($code, $totalPrice);
                    if ($reduce) {
                        $discount += $reduce;
                        list($test, $limit) = $this->limitTest($totalPrice, $discount);
                        if ($test) {
                            $count++;
                            if (isset($previousReduce)) {
                                $codes[$code] = NumberFormat::VND($limit - $previousReduce);
                            } else {
                                $codes[$code] = NumberFormat::VND($limit);
                            }
                            $discount = $limit;
                            $coupons['limit'] = true;
                            if ($count > 1) {
                                $message = 'Đã tối đa giới hạn giảm';
                                unset($codes[$code]);
                            }
                        } else {
                            $codes[$code] = NumberFormat::VND($reduce);
                        }
                        $previousReduce = $reduce;
                    } else {
                        $message = 'Mã giảm giá không khả dụng!';
                        unset($codes[$code]);
                    }
                }
            }
            return APIResponse::make(
                true,
                'info',
                $message,
                [
                    'basePrice' => NumberFormat::VND($basePrice),
                    'reducePrice' => NumberFormat::VND($basePrice - $totalPrice),
                    'subTotal' => NumberFormat::VND($totalPrice),
                    'totalPrice' => NumberFormat::VND($totalPrice - $discount),
                    'codes' => $codes,
                    'coupons' => $coupons
                ]
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return APIResponse::make(false, 'error', $ex->getMessage());
        }
    }

    public function checkout($data)
    {
        try {
            Session::forget(['carts', 'codes']);
            $ids = $data->ids ?? [];
            $ids = array_unique($ids);
            $codes = $data->codes ?? [];
            // $codes = array_map('strtoupper', $codes);
            $codes = array_unique($codes);
            $carts = [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $cart = $this->cartRepository->findById($id);
                    if ($cart) {
                        $carts[] = $id;
                    } else {
                        $carts = [];
                        return false;
                    }
                }
            }
            if (!empty($carts)) {
                Session::put('carts', $carts);
                if (!empty($codes)) {
                    list($base, $total) = $this->makeTotalCarts($ids);
                    foreach ($codes as $key => $code) {
                        $reduce = $this->makeDiscountCost($code, $total);
                        if ($reduce === 0) {
                            unset($codes[$key]);
                        }
                    }
                    Session::put('codes', $codes);
                }
                return APIResponse::make(true, 'success', '', ['link' => route('checkout')]);
            } else {
                return APIResponse::make(false, 'info', 'Bạn chưa chọn khóa học nào');
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
    }

    public function remove($id)
    {
        try {
            // Gate::authorize('delete', $cart);
            $removeCart = $this->cartRepository->removeFromCart($id);
            if ($removeCart) {
                $count = $this->cartRepository->countCart();
                return APIResponse::make(true, 'success', 'Đã xóa khóa học khỏi giỏ hàng.', $count);
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
    }

    public function makeTotalCarts($ids)
    {
        $basePrice = 0;
        $totalPrice = 0;
        try {
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $cart = $this->cartRepository->findById($id);
                    $course = $this->courseRepository->find($cart->course_id);
                    if ($course['success']) {
                        $basePrice += $course['course']['fake_cost'];
                        $totalPrice += $course['course']['cost'];
                    }
                }
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
        return [$basePrice, $totalPrice];
    }

    public function listRecommend()
    {
        $coursesId = $this->cartRepository->getCoursesIdNotInCart();
        return $this->courseRepository->getRandomCoursesNotInCart($coursesId);
    }
    public function count()
    {
        return $this->cartRepository->countCart();
    }
}
