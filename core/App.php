<?php

namespace Core;

class App
{
  private static Container $container;
  private static array $bootedProviders = [];

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

  public static function boot()
  {
    $config = require base_path('config/app.php');
    $providers = $config['providers'] ?? [];

    self::registerProviders($providers);
    self::bootProviders();

  }

  public static function registerProviders(array $providers)
  {
    foreach ($providers as $providerClass) {
      $provider = new $providerClass();
      $provider->register();

      self::$bootedProviders[] = $provider;
    }
  }

  public static function bootProviders()
  {
    foreach (self::$bootedProviders as $provider) {
      $provider->boot();
    }
  }
}