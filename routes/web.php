<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD

Route::get('/', function () {
    return view('welcome');
});
=======
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;


Route::prefix('')->group(function () {

    #Index
    Route::get('', [HomeController::class, 'index'])->name('home');


    #Login
    Route::get('dang-nhap', [HomeController::class, 'login'])->name('login');
    Route::post('dang-nhap', [HomeController::class, 'handleLogin']);

    #Register
    Route::get('dang-ky', [HomeController::class, 'register'])->name('register');
    Route::post('dang-ky', [HomeController::class, 'handleRegister']);

    #Logout
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');

    #Auth
    Route::prefix('')
        ->middleware('auth')
        ->group(function () {

            #Carts
            Route::get('gio-hang', [CartController::class, 'index'])->name('cart');

            #Payment
            Route::get('thanh-toan', [OrderController::class, 'index'])
                ->middleware('checkout')
                ->name('checkout');

            Route::post('thanh-toan', [OrderController::class, 'checkout'])->middleware('checkout');

            Route::get('check-bank', [OrderController::class, 'checkBank'])->middleware('checkout');

            #Result payment
            Route::get('ket-qua', [OrderController::class, 'result'])
                ->name('result');

            Route::get('download-invoice', [OrderController::class, 'download'])
                ->name('download-invoice');

            #Response payment
            Route::get('vnpay-return', [TransactionController::class, 'vnpayReturn'])
                ->name('vnpay.return');

            Route::get('momo-return', [TransactionController::class, 'momoReturn'])
                ->name('momo.return');

            // Route::get('payos-return', [TransactionController::class, 'payOSReturn'])
            //     ->name('payos.return');
        });
});

//API
Route::prefix('carts')
    ->middleware('authenticate')
    ->name('carts.')
    ->group(function () {
        Route::get('', [CartController::class, 'list'])->name('list');
        Route::get('summary', [CartController::class, 'summary'])->name('summary');
        Route::post('add', [CartController::class, 'addToCart'])->name('add');
        Route::post('remove', [CartController::class, 'remove'])->name('remove');
        Route::get('count', [CartController::class, 'count'])->name('count');
        Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::get('recommend', [CartController::class, 'recommend'])->name('recommend');
    });

Route::prefix('courses')->group(function () {
    Route::get('', [CourseController::class, 'get'])->name('courses');
});


#ADMIN
Route::prefix('admin')
    ->middleware('is-admin')
    ->name('admin.')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');

        #Resource
        Route::resource('users', UserController::class);
        Route::resource('courses', AdminCourseController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('configs', ConfigController::class);
        Route::resource('orders', AdminOrderController::class);
    });
>>>>>>> b80dd2f (init commit)
