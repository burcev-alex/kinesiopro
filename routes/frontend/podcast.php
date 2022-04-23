<?php
use App\Domains\Podcast\Http\Controllers\Web\PodcastControllers;
use Illuminate\Support\Facades\Route;

Route::get('/podcast/{param1?}', [PodcastControllers::class, 'index'])->name('podcast')->where('param1', 'page-[0-9]+');
Route::get('/podcast/{slug}/', [PodcastControllers::class, 'show'])->name('podcast.single');
