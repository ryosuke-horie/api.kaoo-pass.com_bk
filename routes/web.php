<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// membersのプレフィックスが付いたルートを定義
Route::prefix('members')->middleware('auth')->group(function () {
    // 一覧
    Route::get('/', [MemberController::class, 'index'])->name('members.index');
    // 新規登録
    Route::get('/create', [MemberController::class, 'create'])->name('members.create');
    // 登録処理
    Route::post('/store', [MemberController::class, 'store'])->name('members.store');
    // 編集
    Route::get('/{member_id}/edit', [MemberController::class, 'edit'])->name('members.edit');
    // 更新処理
    Route::put('/{member_id}', [MemberController::class, 'update'])->name('members.update');
    // 削除
    Route::delete('/{member_id}', [MemberController::class, 'destroy'])->name('members.destroy');
    // 詳細
    Route::get('/{member_id}', [MemberController::class, 'show'])->name('members.show');
});

require __DIR__.'/auth.php';
