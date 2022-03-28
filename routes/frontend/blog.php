<?php
use App\Domains\Blog\Http\Controllers\Web\NewsPaperController;
use Illuminate\Support\Facades\Route;

Route::get('/blog/{param1?}/{param2?}/{param3?}/', [NewsPaperController::class, 'index'])->name('blog');
Route::get('/blog/{slug}/', [NewsPaperController::class, 'show'])->name('blog.single');
