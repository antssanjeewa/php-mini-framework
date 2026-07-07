<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind('db', function () {
  return Database::connect();
});

App::setContainer($container);