<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\StageApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('test', [TestController::class, 'test']);

Route::get('/stages/count', [StageApiController::class, 'count']);
Route::get('/stages/{id}', [StageApiController::class, 'get'])->whereNumber('id');// ←追加// 詳細
