<?php
use Illuminate\Support\Facades\Route;
use App\Domains\Teacher\Http\Controllers\Web\TeacherController;

Route::get('/teachers/{param1?}/', [TeacherController::class, 'index'])->where('param1', 'page-[0-9]+')->name('teacher.index');

Route::get('/teachers/{slug}/', [TeacherController::class, 'show'])->name('teacher.single');
