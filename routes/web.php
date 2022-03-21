<?php

use App\Domains\Feedback\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/feedback/', [FeedbackController::class, "save"])->name("feedback.save");
Route::get('/feedback/', [FeedbackController::class, "index"])->name("feedback.form");


Route::get('/catalog/', [FeedbackController::class, "index"])->name("catalog.card");