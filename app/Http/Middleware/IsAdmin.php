<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                $userRole = Auth::user()->role;
                if ($userRole === 'ADMIN') {
                    return $next($request);
                } else {
                    abort(404);
                }
            }
        } else {
            return redirect()->guest(route('login'));
        }
    }
}
