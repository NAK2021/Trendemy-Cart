<?php

namespace App\Services;

use App\Enums\CouponType;
use Illuminate\Support\Carbon;
use App\Services\Interfaces\CouponServiceInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class CouponService implements CouponServiceInterface
{
    public function __construct(
        protected CouponRepositoryInterface $couponRepository,
        protected OrderRepositoryInterface $orderRepository
    ) {
    }

    public function checkValidCode($code)
    {
        return $this->couponRepository->checkValidCode($code);
    }

    public function findByCode($code)
    {
        return $this->couponRepository->findByCode($code);
    }
}
