<?php
use App\Domains\Order\Http\Controllers\Web\RobokassaControllers;
use Illuminate\Support\Facades\Route;

Route::post('/robokassa/payment', [RobokassaControllers::class, 'payment'])->name('robokassa.payment');
Route::post('/robokassa/success', [RobokassaControllers::class, 'success'])->name('robokassa.success');
Route::post('/robokassa/error', [RobokassaControllers::class, 'error'])->name('robokassa.error');
