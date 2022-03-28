<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\Route;

Route::get('/about-project', [StaticController::class, 'about'])->name('about');
Route::get('/about-project/about-us/', [StaticController::class, 'us'])->name('about.us');
Route::get('/about-project/osnovnye-svedenija-ob-obrazovatelnoj-organizacii/', [StaticController::class, 'organizations'])->name('about.organizations');
Route::get('/about-project/struktura-i-organy-upravlenija-obrazovatelnoj-organizaciej/', [StaticController::class, 'structure'])->name('about.structure');
Route::get('/about-project/dokumenty/', [StaticController::class, 'documents'])->name('about.documents');
Route::get('/about-project/obrazovanie/', [StaticController::class, 'educations'])->name('about.educations');
Route::get('/about-project/rukovodstvo-pedagogicheskij-nauchno-pedagogicheskij-sostav/', [StaticController::class, 'headliners'])->name('about.headliners');
Route::get('/about-project/materialno-tehnicheskoe-obespechenie-i-osnashhennost-obrazovatelnogo-processa/', [StaticController::class, 'materials'])->name('about.materials');