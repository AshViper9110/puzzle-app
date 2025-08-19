<?php

use App\Http\Controllers\StageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users/{user_id}',
    [UserController::class, 'show'])
    ->name('users.show');

Route::post('users/store',
    [UserController::class, 'store'])
    ->name('users.store');

Route::get('users',
    [UserController::class, 'index'])
    ->name('users.index');

Route::get('stages',
    [StageController::class, 'index'])
    ->name('stages.index');

Route::get('stages/{stage_id}',
    [StageController::class, 'cell'])
    ->name('stages.cell');

Route::get('/stages/{id}', [StageController::class, 'get']);// ←追加// 詳細
Route::get('/stages', [StageController::class, 'count']);
