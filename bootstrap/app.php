<?php

<<<<<<< HEAD
=======
use App\Http\Middleware\authenticate;
use App\Http\Middleware\checkout;
use App\Http\Middleware\IsAdmin;
>>>>>>> b80dd2f (init commit)
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
<<<<<<< HEAD
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
=======
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
>>>>>>> b80dd2f (init commit)
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
<<<<<<< HEAD
=======
        // $middleware->alias([]);
        $middleware->alias([
            'authenticate' => authenticate::class,
            'is-admin' => IsAdmin::class,
            'checkout' => checkout::class
        ]);
>>>>>>> b80dd2f (init commit)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
