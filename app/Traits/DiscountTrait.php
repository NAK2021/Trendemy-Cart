<?php

namespace App\Traits;

use Exception;
use App\Enums\CouponType;

trait DiscountTrait
{

    public function makeDiscountCost($code, $cost)
    {
        try {
            if (!$code || $cost <= 0) return 0;

            $usedCodes = $this->getUsedCodes();
            if (in_array($code, $usedCodes)) return 0;

            $coupon = $this->couponRepository->findValidCode($code);
            if (!$coupon) return 0;
            if ($cost < $coupon->min_amount) return 0;
            if ($coupon->type === CouponType::FIXED) {
                return $coupon->value;
            } elseif ($coupon->type === CouponType::PERCENT) {
                $discount = $cost * ($coupon->value / 100);
                return $discount > $coupon->max_amount ? $coupon->max_amount : $discount;
            }
            return 0;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return 0;
        }
    }

    public function findValidCouponsByCost($total)
    {
        try {
            return $this->couponRepository->findValidCouponsByCost($this->getUsedCodes(), $total);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return null;
        }
    }

    public function getUsedCodes()
    {
        try {
            $listPromotions = $this->orderRepository->getUsedPromotionsForUser();
            $listPromotions = json_decode($listPromotions, true);
            $usedCodes = [];

            if (is_array($listPromotions)) {
                foreach ($listPromotions as $promotions) {
                    $promotions = json_decode($promotions, true);
                    if (is_array($promotions)) {
                        foreach ($promotions as $promotion) {
                            if (isset($promotion['code']) && $this->couponRepository->checkValidCode($promotion['code'])) {
                                $usedCodes[] = trim($promotion['code']);
                            }
                        }
                    }
                }
            }
            return $usedCodes;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
    }

    public function limitTest($total, $discount)
    {
        #Nếu chưa đạt giới hạn trả về false, ngược lại true
        try {
            $condition = $this->configService->getDiscountCondition();

            if ($condition) {
                $maxDiscount = $total * ($condition->maximum / 100);

                if ($discount >= $maxDiscount) {
                    return [true, $maxDiscount];
                }

                return [false, $discount];
            }
            return [true, 0];
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return [true, 0];
        }
    }
}
