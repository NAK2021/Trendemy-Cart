<?php

namespace App\Repositories\Interfaces;

interface CouponRepositoryInterface
{
    public function findByCode($code);
    public function findValidCouponsByCost($codes, $total);
    public function findValidCode($code);
    public function checkValidCode($code);
}
