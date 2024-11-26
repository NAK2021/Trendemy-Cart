<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;


class Toast
{
    public static function success($message = '')
    {
        Session::flash('toast', ['type' => 'success', 'message' => $message]);
    }
    public static function info($message = '')
    {
        Session::flash('toast', ['type' => 'info', 'message' => $message]);
    }
    public static function warning($message = '')
    {
        Session::flash('toast', ['type' => 'warning', 'message' => $message]);
    }
    public static function error($message = '')
    {
        Session::flash('toast', ['type' => 'error', 'message' => $message]);
    }
}
