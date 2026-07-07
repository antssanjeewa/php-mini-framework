<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Controllers\HomeController;
use Core\Router;

// require_once('../vendor/autoload.php');
require_once __DIR__ . '/../vendor/autoload.php';

// $request = $_SERVER['REQUEST_URI'];
// 1. URL එක පිරිසිදු කර ගැනීම (Query String අයින් කිරීම)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

echo $request;
echo "<style>body{background:black;color:white;}</style>";
echo "<h1>Welcome to My Mini Framework!</h1>";
echo "<nav><a href='/'>Home</a> | <a href='/about'>About</a> | <a href='/about?id=5'>About-5</a> | <a href='/notfound'>Not Found</a></nav><hr>";


// $notFound = function () {
//   http_response_code(404);
//   return "<h1>404 Not Found</h1>";
// };

// $routes = [
//   '/' => function () {
//     return "<h1>Home Page</h1>";
//   },
//   '/about' => function () {
//     return "<h1>About Us Page</h1>";
//   }
// ];

$router = new Router();

$router->add('/', [HomeController::class, 'index']);
// $router->add('/', [HomeController::class, 'ine']);

$router->add('/about', function () {
  return "<h1>About Us Page</h1>";
});

// echo $router->resolve($request);
try {
  echo $router->resolve($request);
} catch (Exception $e) {
  http_response_code(500);
  echo "<div style='padding: 20px; background: #ffcccc; color: #990000; border: 1px solid #ff0000;'>";
  echo "<h2>Framework Execution Error 🚨</h2>";
  echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
  echo "<p><strong>file:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
  echo "</div>";
}