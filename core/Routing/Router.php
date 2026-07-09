<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\MiddlewareMap;
use ReflectionFunction;
use ReflectionMethod;

class Router
{
  private array $routes = [
    'GET' => [],
    'POST' => []
  ];

  public function add(string $method, string $uri, $callback)
  {
    $routeEl = new RouteElement($method, $uri, $callback);
    $this->routes[strtoupper($method)][$uri] = $routeEl;
    return $routeEl;
  }

  public function resolve(Request $request)
  {
    $method = strtoupper($request->method());
    $routesToScan = $this->routes[$method] ?? [];

    foreach ($routesToScan as $route => $routeElement) {
      $arguments = $this->extractArguments($route, $request->uri());

      if ($arguments !== false) {
        $destination = function () use ($routeElement, $arguments) {
          return $this->executeAction($routeElement, $arguments);
        };

        return $this->runMiddlewarePipeline($routeElement->middleware, $destination);
      }
    }

    return new Response(view('errors/404'), Response::HTTP_NOT_FOUND);
  }

  private function extractArguments($route, $requestUri)
  {

    // Ex: '/user/{id}' -> '/^\/user\/([0-9]+)$/'
    $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_\-]+)', $route);
    $finalPattern = "#^" . $routePattern . "$#";

    // URL Check
    if (preg_match($finalPattern, $requestUri, $matches)) {

      array_shift($matches); // remove url in 0 index
      return $matches; // get only params
    }
    return false;
  }

  private function executeAction($routeElement, $arguments)
  {
    if (is_array($routeElement->action)) {
      if (count($routeElement->action) < 2) {
        throw new \Exception("Route Error: Controller method එක සඳහන් කර නැත!");
      }

      $controllerNode = $routeElement->action[0];
      $method = $routeElement->action[1];

      if (!class_exists($controllerNode)) {
        throw new \Exception("Route Error: Class '{$controllerNode}' සොයාගත නොහැක!");
      }

      $controllerInstance = app("$controllerNode");

      if (!method_exists($controllerInstance, $method)) {
        throw new \Exception("Route Error: Method '{$method}' සොයාගත නොහැක!");
      }

      $reflectionMethod = new ReflectionMethod($controllerInstance, $method);
      $dependencies = $this->resolveActionDependencies($reflectionMethod, $arguments);

      return call_user_func_array([$controllerInstance, $method], $dependencies);
    }

    $reflectionMethod = new ReflectionFunction($routeElement->action);
    $dependencies = $this->resolveActionDependencies($reflectionMethod, $arguments);
    return call_user_func_array($routeElement->action, $dependencies);
  }

  private function runMiddlewarePipeline($middleware, $destination)
  {
    $pipeline = array_reduce(
      array_reverse($middleware),
      function ($nextClosure, $middlewareKey) {
        return function () use ($nextClosure, $middlewareKey) {
          $middlewareClass = MiddlewareMap::find($middlewareKey);
          if ($middlewareClass) {
            $middlewareInstance = new $middlewareClass();
            return $middlewareInstance->handle($nextClosure);
          }
          return $nextClosure();
        };
      },
      $destination
    );
    return $pipeline();
  }

  private function resolveActionDependencies(\ReflectionFunctionAbstract $reflection, array &$arguments): array
  {
    $parameters = $reflection->getParameters();
    $dependencies = [];
    foreach ($parameters as $parameter) {
      $type = $parameter->getType();
      if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
        $dependencies[] = app($type->getName());
      } else {
        if ($parameter->isDefaultValueAvailable()) {
          $dependencies[] = $parameter->getDefaultValue();
        } else {
          $dependencies[] = array_shift($arguments);
        }
      }
    }

    return $dependencies;
  }
}