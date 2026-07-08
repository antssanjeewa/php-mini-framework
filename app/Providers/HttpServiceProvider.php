<?php

namespace App\Providers;

use Core\App;
use Core\Http\Kernel;
use Core\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
  public function register()
  {
    App::singleton(Kernel::class, function () {
      return new Kernel();
    });
  }

  public function boot()
  {

  }
}