<?php

use App\Domains\Order\Http\Controllers\Web\OrderController;
use App\Domains\User\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
        
    // User endpoint
    Route::get('/profile/', [UserController::class, 'index'])->name('profile.index');
    Route::post('/profile/', [UserController::class, 'update'])->name('profile.update');

    // Order endpoints
    Route::get('/orders/', [OrderController::class, 'index'])->name('orders.index');
});