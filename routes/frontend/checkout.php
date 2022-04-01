<?php

use App\Domains\Order\Http\Controllers\Web\CheckoutController;
use Illuminate\Support\Facades\Route;

// создание заказа
Route::post('/checkout/save/', [CheckoutController::class, 'save'])->name('checkout.save');