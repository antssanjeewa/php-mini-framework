<?php


use Core\App;
use Core\Container;
use Core\Http\Request;

$container = new Container();
App::setContainer($container);

App::singleton(Request::class, function () {
  return new Request();
});

App::boot();