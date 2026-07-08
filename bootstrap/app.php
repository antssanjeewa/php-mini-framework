<?php

use Core\App;
use Core\Container;
use Core\Database\Database;
use Core\Http\Request;

$container = new Container();

$container->singleton('db', function () {
  return Database::connect();
});

$container->singleton(Request::class, function () {
  return new Request();
});

App::setContainer($container);