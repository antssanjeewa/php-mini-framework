<?php

namespace Core;

use Exception;

class Container
{
  private array $bindings = [];

  public function bind(string $key, callable $resolve)
  {
    $this->bindings[$key] = $resolve;
  }

  public function get(string $key)
  {
    if (!isset($this->bindings[$key])) {
      throw new Exception("Not register $key");
    }

    return call_user_func($this->bindings[$key]);
  }
}