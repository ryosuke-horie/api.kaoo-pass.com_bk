<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    // 会員一覧機能
    Route::get('/users', [UserController::class, 'index']);

    // 会員登録機能
    Route::post('/users', [UserController::class, 'store']);

    // 会員退会処理
    Route::post('/users/unsubscribe/{userId}/', [UserController::class, 'unsubscribe']);

    // ログアウト機能
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Stripe用のグループ
    Route::group(['prefix' => 'stripe'], function () {
        // Stripeの連結アカウント作成
        Route::get('/create', [StripeController::class, 'create']);
    });
});
