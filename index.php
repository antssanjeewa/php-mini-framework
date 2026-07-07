<?php

echo "<h1>Welcome to My Mini Framework!</h1>";

$request_uri = $_SERVER['REQUEST_URI'];
$base_path = parse_url($request_uri, PHP_URL_PATH);
$request = rtrim($base_path, '/');

// --- CONTROLLERS ---
function homeController()
{
  return "<h1>Home Page</h1><p>Welcome to Valet powered Mini Framework!</p>";
}

function aboutController()
{
  return "<h1>About Us</h1><p>Running smoothly on Nginx.</p>";
}

// --- ROUTER ---
$routes = [
  '' => 'homeController',
  '/about' => 'aboutController'
];

if (array_key_exists($request, $routes)) {
  $action = $routes[$request];
  echo $action();
} else {
  http_response_code(404);
  echo "<h1>404 - Page Not Found (Valet)</h1>";
}