<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\CouponRepositoryInterface;

class CouponRepository implements CouponRepositoryInterface
{
    private $model;
    private $now;
    public function __construct()
    {
        $this->model = Coupon::class;
        $this->now = Carbon::now();
    }

    public function findByCode($code)
    {
        return $this->model::whereRaw("code COLLATE utf8_bin LIKE ?", [$code])->first();
    }

    public function findValidCouponsByCost($codes, $total)
    {
        return $this->model::select('code', 'description')
            ->whereNotIn(DB::raw("code COLLATE utf8_general_ci"), $codes)
            ->where('min_amount', '<=', $total)
            ->where('start_date', '<=', $this->now)
            ->where('expiry_date', '>=', $this->now)
            ->where(function ($query) {
                $query->whereColumn('usage_count', '<', 'usage_limit')
                    ->orWhereNull('usage_limit');
            })
            ->latest()
            ->get();
    }

    public function findValidCode($code)
    {
        return $this->model::whereRaw("code COLLATE utf8_bin LIKE ?", [$code])
            ->where('start_date', '<=', $this->now)
            ->where('expiry_date', '>=', $this->now)
            ->where(function ($query) {
                $query->whereColumn('usage_count', '<', 'usage_limit')
                    ->orWhereNull('usage_limit');
            })
            ->first();
    }

    public function checkValidCode($code)
    {
        return $this->model::whereRaw("code COLLATE utf8_bin LIKE ?", [$code])
            ->where('start_date', '<=', $this->now)
            ->where('expiry_date', '>=', $this->now)
            ->where(function ($query) {
                $query->whereColumn('usage_count', '<', 'usage_limit')
                    ->orWhereNull('usage_limit');
            })
            ->exists();
    }
}
