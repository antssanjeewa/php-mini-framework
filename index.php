<?php

echo "<h1>Welcome to My Mini Framework!</h1>";

$request = $_SERVER['REQUEST_URI'];

// සරල Router එකක් ක්‍රියාත්මක කිරීම
switch ($request) {
  case '/':
  case '':
    echo "<h1>Home Page</h1>";
    break;

  case '/about':
    echo "<h1>About Us Page</h1>";
    break;

  case '/contact':
    echo "<h1>Contact Page</h1>";
    break;

  default:
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    break;
}