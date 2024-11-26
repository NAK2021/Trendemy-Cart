<?php

namespace App\Enums;

class PaymentMethod
{
    const VNPAY = 'VNPAY';
    const MOMO = 'MOMO';
    const BANK = 'BANK';

    public static function getValues()
    {
        return [
            self::VNPAY,
            self::MOMO,
            self::BANK,
        ];
    }
}
