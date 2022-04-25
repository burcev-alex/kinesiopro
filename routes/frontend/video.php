<?php

use App\Domains\Stream\Http\Controllers\Web\LessonController;
use App\Domains\Stream\Http\Controllers\Web\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/video/{param1?}', [VideoController::class, 'index'])->name('stream.index')->where('param1', 'page-[0-9]+');

Route::get('/video/{slug}/', [VideoController::class, 'show'])->name('stream.single');

Route::middleware('auth')->group(function () {
    Route::get('/stream/{stream}/{lessonId}', [LessonController::class, 'show'])->name('stream.single.lesson');
});
