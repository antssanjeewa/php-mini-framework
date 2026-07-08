<?php

namespace App\Providers;

use Core\App;
use Core\Database\Database;
use Core\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
  public function register()
  {
    App::singleton(Database::class, function () {
      $config = require base_path('config/database.php');
      return new Database($config);
    });

    App::singleton('db', function () {
      return App::get(Database::class)->connection();
    });
  }

  public function boot()
  {
  }
}