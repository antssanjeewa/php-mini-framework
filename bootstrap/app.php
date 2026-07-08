<?php

use App\Providers\DatabaseServiceProvider;
use Core\App;
use Core\Container;
use Core\Http\Request;

$container = new Container();
App::setContainer($container);

App::singleton(Request::class, function () {
  return new Request();
});

$dbProvider = new DatabaseServiceProvider();
$dbProvider->register();