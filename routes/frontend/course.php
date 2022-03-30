<?php
use App\Domains\Category\Http\Controllers\Web\CategoriesControllers;
use App\Domains\Course\Http\Controllers\Web\CardControllers;
use Illuminate\Support\Facades\Route;


// Course card
Route::get('/course/{slug}/', [CardControllers::class, 'show'])->name('courses.card');

Route::get('/filters/{param1?}/{param2?}/{param3?}/', [CategoriesControllers::class, 'filters'])->name('courses.filters');

Route::get('/courses/{param1?}/{param2?}/{param3?}/', [CategoriesControllers::class, 'index'])
->name('courses.index');