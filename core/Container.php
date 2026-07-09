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

    if (class_exists($key)) {
      return $this->resolve($key);
    }

    throw new Exception("Not register $key");
  }

  private function resolve(string $class)
  {
    $reflectionClass = new \ReflectionClass($class);

    $constructor = $reflectionClass->getConstructor();

    // if not constructor can create plain object
    if ($constructor === null) {
      return new $class();
    }

    $parameters = $constructor->getParameters();

    $dependencies = [];

    foreach ($parameters as $parameter) {
      $type = $parameter->getType();

      if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
        $dependencies[] = $this->get($type->getName());

      } else {
        if ($parameter->isDefaultValueAvailable()) {
          $dependencies[] = $parameter->getDefaultValue();
        } else {
          throw new Exception("Cannot resolve dependency [{$parameter->getName()}] in class [{$class}]");
        }
      }
    }

    return new $class(...$dependencies);
  }
}