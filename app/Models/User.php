<?php

namespace App\Models;

use Core\Database;

class User
{
  public static function find(int $id)
  {
    $db = Database::connect();

    // SQL Injection වලින් ආරක්ෂා වීමට Prepared Statements පාවිච්චි කරයි
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
  }
}