<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;



// Route::prefix('cart')->middleware(['web', 'authenticate'])->name('carts.')->group(function () {
//     Route::get('get', [CartController::class, 'list'])->name('list');
//     Route::get('summary', [CartController::class, 'summary'])->name('summary');
//     Route::post('add-cart', [CartController::class, 'addToCart'])->name('add');
//     Route::post('remove-cart', [CartController::class, 'remove'])->name('remove');
//     Route::get('recommend-courses', [CartController::class, 'recommend'])->name('recommend');

//     Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');
// });
// Route::prefix('courses')->group(function () {
//     Route::get('', [CourseController::class, 'get'])->name('courses');
// });
