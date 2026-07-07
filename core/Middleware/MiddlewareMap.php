<?php

namespace Core\Middleware;

class MiddlewareMap
{
  public static array $map = [
    'csrf' => VerifyCsrfToken::class
  ];

  public static function find(string $key)
  {
    return self::$map[$key] ?? null;
  }

}