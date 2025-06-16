<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Post
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout']);

//Get
Route::get('auth/index/{error_id?}', [AuthController::class, 'index']);

Route::get('accounts/home', [AccountController::class, 'home']);
Route::get('accounts/index', [AccountController::class, 'index']);
Route::get('accounts/users', [AccountController::class, 'users']);
Route::get('accounts/scores', [AccountController::class, 'scores']);


