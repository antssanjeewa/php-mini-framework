<?php


use App\Controllers\HomeController;
use App\Controllers\UserController;
use Core\Routing\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth');

Route::post('/user/save', [UserController::class, 'store']);