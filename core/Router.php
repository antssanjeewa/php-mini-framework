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
    if (array_key_exists($requestUri, $this->routes)) {
      $action = $this->routes[$requestUri];

      if (is_array($action)) {
        if (count($action) < 2) {
          throw new \Exception("Route error: Controller method is missing for URI: " . $requestUri);
        }

        $controllerNode = $action[0];
        $method = $action[1];

        // Class එක පද්ධතිය තුළ ඇත්දැයි බැලීම
        if (!class_exists($controllerNode)) {
          throw new \Exception("Route Error: Class '{$controllerNode}' සොයාගත නොහැක!");
        }

        $controllerInstance = new $controllerNode();

        // Method එක Class එක ඇතුළේ ඇත්දැයි බැලීම
        if (!method_exists($controllerInstance, $method)) {
          throw new \Exception("Route Error: Method '{$method}' ක්ලාස් එක තුළ සොයාගත නොහැක!");
        }

        return $controllerInstance->$method();
      }

      return $action();
    }

    http_response_code(404);
    return "<h1>404 Not Found (via Router Class)</h1>";
  }
}