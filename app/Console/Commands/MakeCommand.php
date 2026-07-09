<?php

namespace App\Console\Commands;

use Core\Console\Command;

class MakeCommand extends Command
{
  public function execute($action, $args)
  {
    $migrationName = $args[0] ?? null;

    if (!$migrationName) {
      echo "\033[31m❌ Please provide a migration name! (e.g., php ace make:migration create_posts_table)\033[0m" . PHP_EOL;
      exit(1);
    }

    if ($action === 'migration') {
      $timestamp = date('Y_m_d_His');
      $fileName = "m_{$timestamp}_{$migrationName}.php";
      $filePath = base_path("/database/migrations/{$fileName}");

      $stubPath = base_path('/core/stubs/migration.stub');
      $stubContent = file_get_contents($stubPath);

      $finalContent = str_replace('{{migrationName}}', $migrationName, $stubContent);

      file_put_contents($filePath, $finalContent);
      echo "\033[32m✨ Created Migration: {$fileName}\033[0m" . PHP_EOL;
    }
  }
}