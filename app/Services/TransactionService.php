<?php

namespace App\Services;

use App\Enums\CartState;
use App\Enums\OrderState;
use App\Enums\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionService implements TransactionServiceInterface
{

    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected OrderRepositoryInterface $orderRepository,
        protected CouponRepositoryInterface $couponRepository,
        protected CartRepositoryInterface $cartRepository
    ) {
    }

    public function create($request, $method)
    {
        if ($method === PaymentMethod::VNPAY) {
            $orderId = $request->vnp_OrderInfo;
            $statusCode = $request->vnp_ResponseCode == '00' ? true : false;
            $response = $request->all();
        } elseif ($method === PaymentMethod::MOMO) {
            $orderId = $request->requestId;
            $statusCode = $request->resultCode == '0' ? true : false;
            $response = $request->all();
        } elseif ($method === PaymentMethod::BANK) {
            $orderId = $request['orderCode'];
            $statusCode = $request['status'] == 'PAID' ? true : false;
            $response = $request;
        }
        $order = $this->orderRepository->find($orderId);
        if ($order) {
            DB::beginTransaction();
            try {
                $this->transactionRepository->create([
                    'user_id' => Auth::user()->id,
                    'payment_method' => $method,
                    'order_id' => $order->id,
                    'response' => json_encode($response)
                ]);
                if ($statusCode) {
                    $order->state = OrderState::PAID;
                    $order->save();
                    $ids = Session::get('carts');
                    foreach ($ids as $id) {
                        $cart = $this->cartRepository->findById($id);
                        if ($cart) {
                            $cart->state = CartState::PURCHASED;
                            $cart->save();
                        }
                    }
                    if (Session::has('codes')) {
                        $codes = Session::get('codes');
                        foreach ($codes as $code) {
                            $coupon = $this->couponRepository->findByCode($code);
                            if ($coupon) {
                                $coupon->usage_count++;
                                $coupon->save();
                            }
                        }
                    }
                    Session::forget(['carts', 'codes']);
                } else {
                    $order->state = OrderState::FAILED;
                    $order->save();
                }
                DB::commit();
                return $statusCode ? $order->id : false;
            } catch (\Exception $ex) {
                DB::rollback();
                Log::error('VNPay transaction failed: ' . $ex->getMessage());
                return false;
            }
        }
        return false;
    }
}
