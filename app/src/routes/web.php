<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Post
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('index/{error_id?}', 'index')->name('auth.index');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
});


Route::prefix('accounts')->controller(AccountController::class)->middleware(AuthMiddleware::class)->group(function () {
    Route::get('index', 'index')->name('accounts.index');
    Route::get('home', 'home')->name('accounts.home');
    Route::get('users', 'users')->name('accounts.users');
    Route::get('items', 'items')->name('accounts.items');
    Route::get('achievements', 'achievements')->name('accounts.achievements');
});

Route::prefix('store')->controller(StoreController::class)->middleware(AuthMiddleware::class)->group(function () {
    Route::get('create', 'create')->name('store.create');
    Route::post('set', 'set')->name('store.set');
    Route::get('completion', 'completion')->name('store.completion');
    Route::get('delete/{name}', 'delete')->name('store.delete');
    Route::post('delete/{name}', 'destroy')->name('store.destroy');
    Route::get('update/{id}', 'edit')->name('store.edit');    // 編集フォーム表示（GET）
    Route::post('update/{id}', 'update')->name('store.update'); // 更新処理（POST）
});

Route::get('/stage/index', [StageController::class, 'index'])->name('stage.index');       // 一覧
Route::get('/stage/index/{id}', [StageController::class, 'show'])->name('stage.show');
Route::post('/stage/upload', [StageController::class, 'upload'])->name('stage.upload');
Route::get('/stages/count', [StageController::class, 'count']);
Route::get('/stage/create', [StageController::class, 'Createshow'])->name('stage.create');
Route::get('/stages/{id}', [StageController::class, 'get']);// ←追加// 詳細



