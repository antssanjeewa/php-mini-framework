<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Core\Routing\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/user', [UserController::class, 'indexs']);
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth');

Route::post('/user/save', [UserController::class, 'store']);