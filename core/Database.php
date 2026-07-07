<?php
namespace Core;

use PDO;
use PDOException;
use Exception;

class Database
{
  private static ?PDO $instance = null;

  /**
   * Database Connection එක ලබාදෙන මධ්‍යගත Method එක
   */
  public static function connect(): PDO
  {
    if (self::$instance === null) {

      $config = require __DIR__ . '/../config/database.php';

      $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

      // PDO සඳහා අමතර Settings (Error Handling සහ Fetch Mode)
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];

      try {
        self::$instance = new PDO($dsn, $config['username'], $config['password'], $options);
      } catch (PDOException $e) {
        throw new Exception("Database Connection Error 🔌: " . $e->getMessage());
      }
    }

    return self::$instance;
  }
}