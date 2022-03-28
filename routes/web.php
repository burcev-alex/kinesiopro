<?php

use App\Domains\Category\Http\Controllers\Web\CategoriesControllers;
use App\Domains\Course\Http\Controllers\Web\CardControllers;
use App\Domains\Feedback\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/feedback/', [FeedbackController::class, "save"])->name("feedback.save");
Route::get('/feedback/', [FeedbackController::class, "index"])->name("feedback.form");
Route::get('/contacts/', [ContactsController::class, 'index'])->name('contacts');



// Product card
Route::get('/course/{slug}/', [CardControllers::class, 'show'])->name('courses.card');

// Filters catalog route should be in the bottom
Route::get('/filters/{param1?}/{param2?}/{param3?}/', [CategoriesControllers::class, 'filters'])->name('courses.filters');

// Filters catalog route should be in the bottom
Route::get('/courses/{param1?}/{param2?}/{param3?}/', [CategoriesControllers::class, 'index'])
->name('courses.index');


includeRouteFiles(__DIR__ . '/frontend/');