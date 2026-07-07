<?php

echo "<h1>Welcome to My Mini Framework!</h1>";
echo "<nav><a href='/'>Home</a> | <a href='/about'>About</a> | <a href='/notfound'>Not Found</a></nav><hr>";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// -----------------------------------------
// 1. CONTROLLER CLASSES (Logic වෙන් කිරීම)
// -----------------------------------------
class HomeController
{
  public function index()
  {
    return "<h1>Home Page (via HomeController)</h1>";
  }
}

class AboutController
{
  public function index()
  {
    return "<h1>About Us Page (via AboutController)</h1>";
  }
}

// -----------------------------------------
// 1. ROUTER CLASS එක (Router එකේ වගකීම)
// -----------------------------------------
class Router
{
  // Routes ටික රහසිගතව තබා ගන්නා Array එක
  private array $routes = [];

  // Route එකක් පද්ධතියට එකතු කරන Method එක
  public function add(string $uri, $callback)
  {
    $this->routes[$uri] = $callback;
  }

  // පැමිණි Request එක පරීක්ෂා කර ක්‍රියාත්මක කරන Method එක
  public function resolve(string $requestUri)
  {
    if (array_key_exists($requestUri, $this->routes)) {
      $action = $this->routes[$requestUri];

      // 💡 ගැටලුව විසඳීම: $action එක array එකක්ද කියා බැලීම
      if (is_array($action)) {
        // $action[0] කියන්නේ Class එක (උදා: HomeController)
        // $action[1] කියන්නේ Method එක (උදා: 'index')
        $controllerNode = $action[0];
        $method = $action[1];

        // Class එකෙන් Object එකක් dynamic ලෙස සෑදීම (new HomeController())
        $controllerInstance = new $controllerNode();

        // Object එක ඇතුළේ තියෙන method එක run කිරීම ($controllerInstance->index())
        return $controllerInstance->$method();
      }

      // Closure එකක් නම් කලින් වගේම run කරනවා
      return $action();
    }

    http_response_code(404);
    return "<h1>404 Not Found (via Router Class)</h1>";
  }
}

// Router එකෙන් Object එකක් හදාගන්නවා
$router = new Router();

$router->add('/', [HomeController::class, 'index']);
$router->add('/about', [AboutController::class, 'index']);

// අවසානයේ Request එක බාරදී ක්‍රියාත්මක කරවනවා
echo $router->resolve($request);