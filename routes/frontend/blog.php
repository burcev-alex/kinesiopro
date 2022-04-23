<?php
use App\Domains\Blog\Http\Controllers\Web\NewsPaperController;
use Illuminate\Support\Facades\Route;

Route::get('/blog/{param1?}', [NewsPaperController::class, 'index'])->name('blog')->where('param1', 'page-[0-9]+');
Route::get('/blog/{slug}/', [NewsPaperController::class, 'show'])->name('blog.single');
