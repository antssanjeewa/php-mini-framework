<?php

namespace App\Providers;

use Core\App;
use Core\Routing\Router;
use Core\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  public function register()
  {
    App::singleton(Router::class, function () {
      return new Router();
    });
  }

  public function boot()
  {
    require_once base_path('routes/web.php');
  }
}