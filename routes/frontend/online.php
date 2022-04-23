<?php
use App\Domains\Online\Http\Controllers\Web\OnlineControllers;
use Illuminate\Support\Facades\Route;


Route::get('/online-courses/{param1?}/{param2?}/', [OnlineControllers::class, 'index'])->where('param2', 'page-[0-9]+')->where('param1', 'marafon|course|conference|webinar|video|page-[0-9]+')->name('online');

Route::get('/online-courses/{slug}/', [OnlineControllers::class, 'show'])->name('online.single');
