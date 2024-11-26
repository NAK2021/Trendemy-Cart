<?php

namespace App\Helpers;


class NumberFormat
{
    public static function VND($vnd)
    {
        return number_format($vnd, 0, ",", ".") . ' đ';
    }
}
