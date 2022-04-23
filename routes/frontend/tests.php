<?php
use App\Domains\Quiz\Http\Controllers\Web\QuizItemController;
use Illuminate\Support\Facades\Route;

Route::get('/tests/{param1?}', [QuizItemController::class, 'index'])->name('tests')->where('param1', 'page-[0-9]+');
Route::get('/tests/{slug}/', [QuizItemController::class, 'show'])->name('tests.single');
