<?php

namespace App\Enums;

class CouponType
{
    const PERCENT = 'PERCENT';
    const FIXED = 'FIXED';

    public static function getValues()
    {
        return [
            self::FIXED,
            self::PERCENT
        ];
    }
}
