<?php

use App\Domains\Order\Http\Controllers\Web\OrderController;
use App\Domains\User\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
        
    // User endpoint
    Route::get('/profile/', [UserController::class, 'index'])->name('profile.index');
    Route::post('/profile/', [UserController::class, 'update'])->name('profile.update');

    // Order endpoints
    Route::get('/orders/{type?}', [OrderController::class, 'index'])->where('type', 'marafon|course|conference|webinar|video')->name('orders.index');

    // уведомления
    Route::get('/notifications/', [UserController::class, 'notifications'])->name('profile.notifications');
});