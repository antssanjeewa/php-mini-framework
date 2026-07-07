<?php
namespace Core;

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
    self::getRouter()->add('GET', $uri, $action);
  }

  public static function post(string $uri, $action)
  {
    self::getRouter()->add('POST', $uri, $action);
  }

  public static function handle(string $requestUri, string $requestMethod)
  {
    return self::getRouter()->resolve($requestUri, $requestMethod);
  }
}