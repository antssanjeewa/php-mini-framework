<?php

echo "<h1>Welcome to My Mini Framework!</h1>";
echo "<nav><a href='/'>Home</a> | <a href='/about'>About</a> | <a href='/notfound'>Not Found</a></nav><hr>";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// --- ROUTER & LOGIC ---
// අපි වෙනම තිබුණු ෆන්ක්ෂන්ස් අයින් කරලා, කෙලින්ම Array එක ඇතුළෙම ඒවා ලිව්වා.
$routes = [
  '/' => function () {
    return "<h1>Home Page</h1>";
  },
  '/about' => function () {
    return "<h1>About Us Page</h1>";
  }
];

// 404 සඳහාත් නමක් නැති ෆන්ක්ෂන් එකක් Variable එකකට ගනිමු
$notFound = function () {
  http_response_code(404);
  return "<h1>404 Not Found</h1>";
};

// Route එක පරීක්ෂා කර ක්‍රියාත්මක කිරීම
if (array_key_exists($request, $routes)) {
  // දැන් $routes[$request] එකෙන් ලැබෙන්නේ executable function එකක් (Closure)
  $action = $routes[$request];
  echo $action();
} else {
  echo $notFound();
}