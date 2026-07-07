<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router->add('/', [HomeController::class, 'index']);
$router->add('/user', [UserController::class, 'index']);
$router->add('/user/{id}', [UserController::class, 'show']);