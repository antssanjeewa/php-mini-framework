<?php

namespace Core;

use Exception;

class Container
{
  private array $bindings = [];
  protected array $instances = [];

  public function bind(string $key, callable $resolve)
  {
    $this->bindings[$key] = $resolve;
  }

  public function singleton(string $key, callable $resolve)
  {
    $this->bindings[$key] = $resolve;
    $this->instances[$key] = null;
  }

  public function get(string $key)
  {
    if (array_key_exists($key, $this->instances) && $this->instances[$key] !== null) {
      return $this->instances[$key];
    }

    if (isset($this->bindings[$key])) {
      $object = call_user_func($this->bindings[$key]);

      if (array_key_exists($key, $this->instances)) {
        $this->instances[$key] = $object;
      }

      return $object;
    }

    throw new Exception("Not register $key");
  }
}