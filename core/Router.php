<?php

namespace Core;

class Router
{
  private array $routes = [];

  public function add(string $uri, $callback)
  {
    $this->routes[$uri] = $callback;
  }

  public function resolve(string $requestUri)
  {
    // 1. හැම රූට් එකක්ම පරීක්ෂා කිරීම සඳහා ලූප් එකක් භාවිතා කරයි
    foreach ($this->routes as $route => $action) {

      // සාමාන්‍ය රූට් එකක් Regex රටාවකට හැරවීම
      // උදා: '/user/{id}' -> '/^\/user\/([0-9]+)$/'
      $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', $route);
      $finalPattern = "#^" . $routePattern . "$#";

      // බ්‍රවුසර් URL එක සහ රූට් රටාව ගැලපේදැයි බැලීම
      if (preg_match($finalPattern, $requestUri, $matches)) {
        // print_r($matches);
        // URL එකේ තිබුණු ID (Arguments) ටික වෙන් කර ගැනීම
        // $matches[0] වල තියෙන්නේ මුළු URL එකමයි, $matches[1] වල ඉඳන් තමා අගයන් තියෙන්නේ
        array_shift($matches); // පළමු අගය ඉවත් කරයි
        $arguments = $matches; // දැන් මෙහි [5] වැනි අගයන් පවතී

        // 2. Action එක Array එකක් නම් (Controller Handling)
        if (is_array($action)) {
          if (count($action) < 2) {
            throw new \Exception("Route Error: Controller method එක සඳහන් කර නැත!");
          }

          $controllerNode = $action[0];
          $method = $action[1];

          if (!class_exists($controllerNode)) {
            throw new \Exception("Route Error: Class '{$controllerNode}' සොයාගත නොහැක!");
          }

          $controllerInstance = new $controllerNode();

          if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Route Error: Method '{$method}' සොයාගත නොහැක!");
          }

          // 💡 වැදගත්ම දේ: Arguments ද සමඟින් Method එක dynamic ලෙස run කිරීම
          return call_user_func_array([$controllerInstance, $method], $arguments);
        }

        // 3. Action එක Closure (Function) එකක් නම්
        return call_user_func_array($action, $arguments);
      }
    }

    // කිසිම රූට් එකක් මැච් වුණේ නැත්නම් 404
    http_response_code(404);
    return "<h1>404 Not Found (via Advanced Router)</h1>";
  }
}