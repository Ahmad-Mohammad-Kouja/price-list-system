<?php

use App\Src\Users\Entities\Controllers\AuthController;
use App\Src\Users\Inventories\Controllers\ProductController;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')
            ->name('logout')
            ->middleware('auth:user');
    });


Route::prefix('products')
    ->name('products.')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{productId}', 'show')->name('show');
    });
