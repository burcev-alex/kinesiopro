<?php

use App\Domains\User\Http\Controllers\Web\RegisteredUserController;
use App\Domains\User\Http\Controllers\Web\AuthenticatedSessionController;
use App\Domains\User\Http\Controllers\Web\PasswordResetLinkController;
use App\Domains\User\Http\Controllers\Web\NewPasswordController;
// use App\Http\Controllers\Auth\VerifyEmailController;
use App\Domains\User\Http\Controllers\Web\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::get('/register/', [RegisteredUserController::class, 'create'])
        ->name('register.create');
        
    Route::post('/register/', [RegisteredUserController::class, 'store'])
        ->name('register.post');

    Route::get('/login/', [AuthenticatedSessionController::class, 'create'])
        ->name('auth.login');

    Route::post('/login/', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');

    Route::post('/forgot-password/', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}/', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password/', [NewPasswordController::class, 'store'])
        ->name('password.update');

    Route::get('/auth/redirect/{driver}', [SocialiteController::class, 'index'])
        ->name('socials.index')
        ->where(['driver' => '^(google|facebook)$']);

    Route::get('/login/google/callback/', [SocialiteController::class, 'google'])->name('google');
    Route::get('/login/facebook/callback/', [SocialiteController::class, 'facebook'])->name('facebook');
});

Route::get('/logout/', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Route::get('/verify-email/{id}/{hash}/', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['auth', 'signed', 'throttle:6,1'])
//     ->name('verification.verify');