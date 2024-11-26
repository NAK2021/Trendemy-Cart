<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
<<<<<<< HEAD
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
=======
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
>>>>>>> b80dd2f (init commit)
    require $maintenance;
}

// Register the Composer autoloader...
<<<<<<< HEAD
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
=======
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')->handleRequest(Request::capture());
>>>>>>> b80dd2f (init commit)
