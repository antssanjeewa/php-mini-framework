<?php

namespace Core;

class App
{
  private static Container $container;

  public static function setContainer(Container $container)
  {
    self::$container = $container;
  }

  public static function get(string $key)
  {
    return self::$container->get($key);
  }

  public static function bind(string $key, callable $resolver)
  {
    self::$container->bind($key, $resolver);
  }

  public static function singleton(string $key, callable $resolver)
  {
    self::$container->singleton($key, $resolver);
  }
}