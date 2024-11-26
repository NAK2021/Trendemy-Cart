<?php

namespace App\Services\Interfaces;

interface CouponServiceInterface
{
    // public function makeDiscountCost($code, $cost);
    // public function findValidCouponsByCost($total);
    public function findByCode($code);
    public function checkValidCode($code);
}
