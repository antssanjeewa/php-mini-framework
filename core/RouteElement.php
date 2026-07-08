<?php

namespace Core;

class RouteElement
{
  public string $method;
  public string $uri;
  public $action;
  public array $middleware = [];

  public function __construct($method, $uri, $action)
  {
    $this->method = $method;
    $this->uri = $uri;
    $this->action = $action;
  }

  public function middleware($name)
  {
    $names = explode(',', $name);

    foreach ($names as $middlewareName) {

      if (!in_array($middlewareName, $this->middleware)) {

        $this->middleware[] = $middlewareName;
      }
    }

    return $this;
  }
}