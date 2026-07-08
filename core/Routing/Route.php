<?php
namespace Core\Routing;

use Core\App;

class Route
{
  private static ?Router $routerInstance = null;

  private static function getRouter(): Router
  {
    if (self::$routerInstance === null) {
      self::$routerInstance = App::get(Router::class);
    }
    return self::$routerInstance;
  }

  public static function get(string $uri, $action)
  {
    return self::getRouter()->add('GET', $uri, $action);
  }

  public static function post(string $uri, $action)
  {
    return self::getRouter()->add('POST', $uri, $action);
  }

  public static function handle($request)
  {
    return self::getRouter()->resolve($request);
  }
}