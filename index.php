<?php

echo "<h1>Welcome to My Mini Framework!</h1>";
echo "<nav><a href='/'>Home</a> | <a href='/about'>About</a> | <a href='/notfound'>Not Found</a></nav><hr>";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// -----------------------------------------
// 1. ROUTER CLASS එක (Router එකේ වගකීම)
// -----------------------------------------
class Router
{
  // Routes ටික රහසිගතව තබා ගන්නා Array එක
  private array $routes = [];

  // Route එකක් පද්ධතියට එකතු කරන Method එක
  public function add(string $uri, callable $callback)
  {
    $this->routes[$uri] = $callback;
  }

  // පැමිණි Request එක පරීක්ෂා කර ක්‍රියාත්මක කරන Method එක
  public function resolve(string $requestUri)
  {
    if (array_key_exists($requestUri, $this->routes)) {
      $action = $this->routes[$requestUri];
      return $action();
    }

    http_response_code(404);
    return "<h1>404 Not Found (via Router Class)</h1>";
  }
}

// Router එකෙන් Object එකක් හදාගන්නවා
$router = new Router();

// Laravel වල වගේ ලස්සනට Routes එකතු කරනවා
$router->add('/', function () {
  return "<h1>Home Page</h1>";
});

$router->add('/about', function () {
  return "<h1>About Us Page</h1>";
});

// අවසානයේ Request එක බාරදී ක්‍රියාත්මක කරවනවා
echo $router->resolve($request);