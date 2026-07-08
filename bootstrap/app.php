<?php

use Core\App;
use Core\Container;
use Core\Database;
use Core\Request;

$container = new Container();

$container->singleton('db', function () {
  return Database::connect();
});

$container->singleton(Request::class, function () {
  return new Request();
});

App::setContainer($container);