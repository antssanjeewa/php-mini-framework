<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Core\ExceptionHandler;
use Core\Router;

// require_once('../vendor/autoload.php');
require_once __DIR__ . '/../vendor/autoload.php';

// $request = $_SERVER['REQUEST_URI'];
// 1. URL එක පිරිසිදු කර ගැනීම (Query String අයින් කිරීම)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();

// 2. වෙන් කරන ලද Routes ෆයිල් එක සම්බන්ධ කිරීම
require_once __DIR__ . '/../routes/web.php';

// echo $router->resolve($request);
try {
  echo $router->resolve($request);
} catch (Exception $e) {
  ExceptionHandler::handle($e);
}