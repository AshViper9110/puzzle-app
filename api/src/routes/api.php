<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('test', [TestController::class, 'test']);

Route::get('/stages/count', [StageController::class, 'count']);
Route::get('/stages/{id}', [StageController::class, 'get'])->whereNumber('id');// ←追加// 詳細
