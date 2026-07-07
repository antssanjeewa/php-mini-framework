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
      // ඔබේ Database විස්තර මෙතන ඇතුළත් කරන්න
      $host = '127.0.0.1';
      $db = 'mini_framework';
      $user = 'root';      // ඔබේ MySQL Username එක
      $pass = 'root';          // ඔබේ MySQL Password එක
      $charset = 'utf8mb4';

      $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

      // PDO සඳහා අමතර Settings (Error Handling සහ Fetch Mode)
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];

      try {
        self::$instance = new PDO($dsn, $user, $pass, $options);
      } catch (PDOException $e) {
        throw new Exception("Database Connection Error 🔌: " . $e->getMessage());
      }
    }

    return self::$instance;
  }
}