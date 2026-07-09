<?php

namespace App\Console\Commands;

use Core\Console\Command;

class MigrateCommand extends Command
{
  public function execute($action, $args)
  {
    echo "\033[32mStarting migrations..." . PHP_EOL;

    $migrationsFolder = base_path('/database/migrations/');
    $allFiles = scandir($migrationsFolder);
    $migrationFiles = array_diff($allFiles, ['.', '..']);

    if ($action === 'refresh') {
      $reversedFiles = array_reverse($migrationFiles);
      foreach ($reversedFiles as $file) {
        require_once $migrationsFolder . '/' . $file;

        try {
          $className = pathinfo($file, PATHINFO_FILENAME);
          echo "Applying: $className" . PHP_EOL;

          $migration = new $className();
          $migration->down();
          echo "✅ Successfully truncate: $className" . PHP_EOL . PHP_EOL;
        } catch (\Throwable $e) {
          echo "\033[31m❌ Migration Failed!" . PHP_EOL;
          echo "📁 File: " . $file . PHP_EOL;
          echo "💬 Error Message: " . $e->getMessage() . PHP_EOL;
          echo "📍 Line: " . $e->getLine() . PHP_EOL;
          exit(1);
        }
      }

    }

    foreach ($migrationFiles as $file) {
      require_once $migrationsFolder . '/' . $file;

      try {
        $className = pathinfo($file, PATHINFO_FILENAME);
        echo "Applying: $className" . PHP_EOL;

        $migration = new $className();
        $migration->up();
        echo "✅ Successfully applied: $className" . PHP_EOL . PHP_EOL;

      } catch (\Throwable $e) {
        echo "\033[31m❌ Migration Failed!" . PHP_EOL;
        echo "📁 File: " . $file . PHP_EOL;
        echo "💬 Error Message: " . $e->getMessage() . PHP_EOL;
        echo "📍 Line: " . $e->getLine() . PHP_EOL;
        exit(1);
      }
    }
    echo "\033[32mSuccessfully migrated!" . PHP_EOL;
  }
}