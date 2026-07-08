<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Core\ExceptionHandler;
use Core\Routing\Route;

define('BASE_PATH', dirname(__DIR__) . '/');

// require_once('../vendor/autoload.php');
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';


try {
  echo Route::handle(request());
} catch (Exception $e) {
  ExceptionHandler::handle($e);
}