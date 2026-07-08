<?php


use Core\App;
use Core\Container;
use Core\Http\Request;

define('BASE_PATH', dirname(__DIR__) . '/');

$container = new Container();
App::setContainer($container);

App::singleton(Request::class, function () {
  return new Request();
});

App::boot();