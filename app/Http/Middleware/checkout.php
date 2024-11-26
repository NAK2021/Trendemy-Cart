<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class checkout
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('carts') || empty(Session::get('carts'))) {
            return redirect()->route('cart');
        }

        return $next($request);
    }
}
