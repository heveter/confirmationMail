<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::post('confirmation-email', [AuthController::class, 'confirmationEmail'])
            ->name('confirmation-email');

        Route::get('get-confirm-methods', [UserController::class, 'getAvailableNotificationMethods']);
        Route::post('send-confirm-code', [UserController::class, 'sendConfirmCode']);
    });
});
