<?php

namespace Core;

class RouteElement
{
  public string $method;
  public string $uri;
  public $action;
  public ?string $middleware = null;

  public function __construct($method, $uri, $action)
  {
    $this->method = $method;
    $this->uri = $uri;
    $this->action = $action;
  }

  public function middleware($name)
  {
    $this->middleware = $name; // 💡 ලැබෙන middleware නම object එකේ සේව් කරගනී

    return $this; // 💡 Method Chaining දිගටම කරගෙන යාමට තමන්වම return කරයි!
  }
}