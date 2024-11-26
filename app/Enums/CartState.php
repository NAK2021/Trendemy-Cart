<?php

namespace App\Enums;

class CartState
{
    const PENDING = 'PENDING';
    const PURCHASED = 'PURCHASED';
    const REMOVED = 'REMOVED';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::PURCHASED,
            self::REMOVED,
        ];
    }
}
