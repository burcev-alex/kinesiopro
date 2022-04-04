<?php
use App\Domains\Order\Http\Controllers\Web\RobokassaControllers;
use App\Domains\Order\Http\Controllers\Web\SberbankControllers;
use Illuminate\Support\Facades\Route;

Route::post('/robokassa/payment', [RobokassaControllers::class, 'payment'])->name('robokassa.payment');
Route::post('/robokassa/success', [RobokassaControllers::class, 'success'])->name('robokassa.success');
Route::post('/robokassa/error', [RobokassaControllers::class, 'error'])->name('robokassa.error');

Route::post('/sberbank/success', [SberbankControllers::class, 'success'])->name('sberbank.success');
Route::post('/sberbank/error', [SberbankControllers::class, 'error'])->name('sberbank.error');
