<?php

// වැරදි තිරයේ පෙන්වීම සඳහා (Development වලදී පමණක්)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        // 💡 Array එකේ අගයන් 2ක් (Class සහ Method) තියෙනවාදැයි බැලීම
        if (count($action) < 2) {
          throw new Exception("Route Error: Controller method එක සඳහන් කර නැත! URI: " . $requestUri);
        }

        $controllerNode = $action[0];
        $method = $action[1];

        // Class එක පද්ධතිය තුළ ඇත්දැයි බැලීම
        if (!class_exists($controllerNode)) {
          throw new Exception("Route Error: Class '{$controllerNode}' සොයාගත නොහැක!");
        }

        $controllerInstance = new $controllerNode();

        // Method එක Class එක ඇතුළේ ඇත්දැයි බැලීම
        if (!method_exists($controllerInstance, $method)) {
          throw new Exception("Route Error: Method '{$method}' ක්ලාස් එක තුළ සොයාගත නොහැක!");
        }

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

// 💡 TRY-CATCH භාවිතයෙන් ERROR HANDLING සිදුකිරීම
try {
  // Router එක ක්‍රියාත්මක කිරීමට උත්සාහ කරයි
  echo $router->resolve($request);
} catch (Exception $e) {
  // කිසියම් Exception එකක් විසි වුවහොත් එය මෙතැනින් අසුකර ගනී
  http_response_code(500);
  echo "<div style='padding: 20px; background: #ffcccc; color: #990000; border: 1px solid #ff0000;'>";
  echo "<h2>Framework Execution Error 🚨</h2>";
  echo "<p><strong>පණිවිඩය:</strong> " . $e->getMessage() . "</p>";
  echo "<p><strong>ගොනුව:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
  echo "</div>";
}