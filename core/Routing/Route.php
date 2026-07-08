<?php
namespace Core\Routing;

class Route
{
  private static ?Router $routerInstance = null;

  private static function getRouter(): Router
  {
    if (self::$routerInstance === null) {
      self::$routerInstance = new Router();
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