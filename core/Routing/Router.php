<?php

namespace Core\Routing;

use Core\Http\Request;
use Core\Middleware\MiddlewareMap;

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

    // කිසිම රූට් එකක් මැච් වුණේ නැත්නම් 404
    http_response_code(404);
    return view('errors/404');
  }

  private function extractArguments($route, $requestUri)
  {
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
      return $matches; // දැන් මෙහි [5] වැනි අගයන් පවතී
    }
    return false;
  }

  private function executeAction($routeElement, $arguments)
  {
    $finalArguments = array_merge([request()], $arguments);

    // 2. Action එක Array එකක් නම් (Controller Handling)
    if (is_array($routeElement->action)) {
      if (count($routeElement->action) < 2) {
        throw new \Exception("Route Error: Controller method එක සඳහන් කර නැත!");
      }

      $controllerNode = $routeElement->action[0];
      $method = $routeElement->action[1];

      if (!class_exists($controllerNode)) {
        throw new \Exception("Route Error: Class '{$controllerNode}' සොයාගත නොහැක!");
      }

      $controllerInstance = new $controllerNode();

      if (!method_exists($controllerInstance, $method)) {
        throw new \Exception("Route Error: Method '{$method}' සොයාගත නොහැක!");
      }

      // 💡 වැදගත්ම දේ: Arguments ද සමඟින් Method එක dynamic ලෙස run කිරීම
      return call_user_func_array([$controllerInstance, $method], $finalArguments);
    }

    // 3. Action එක Closure (Function) එකක් නම්
    return call_user_func_array($routeElement->action, $finalArguments);
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
}