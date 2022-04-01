<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\Route;


Route::get('/publichnyj-dogovor-oferta-okazanija-konsultacionnyh-uslug', [StaticController::class, 'publicOffer'])->name('public_offer');
Route::get('/coglasie-na-obrabotku-personalnyh-dannyh', [StaticController::class, 'privacyPolicy'])->name('privacy_policy');