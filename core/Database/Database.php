<?php
namespace Core\Database;

use PDO;
use PDOException;
use Exception;

class Database
{

  private PDO $pdo;

  public function __construct(array $config)
  {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
      $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
    } catch (PDOException $e) {
      throw new Exception("Database Connection Error 🔌: " . $e->getMessage());
    }
  }

  public function connection(): PDO
  {
    return $this->pdo;

  }
}