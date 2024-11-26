<?php

namespace App\Enums;

class OrderState
{
    const PENDING = 'PENDING';
    const PAID  = 'PAID';
    const FAILED = 'FAILED';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::PAID,
            self::FAILED,
        ];
    }
}
