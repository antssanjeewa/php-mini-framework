<?php

use Core\Route;
use App\Controllers\HomeController;
use App\Controllers\UserController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);

Route::post('/user/save', [UserController::class, 'store']);