<?php
use App\Domains\User\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group([
    'prefix' => '/v2',
    'namespace' => 'Api',
    'as' => 'api.'], function () {
        Route::post('telegram/hooks', [TelegramController::class, 'hooks']);
    }
);
