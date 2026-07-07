<?php

namespace App\Models;

use Core\App;

class User
{
  public static function find(int $id)
  {
    $db = App::get('db');

    // SQL Injection වලින් ආරක්ෂා වීමට Prepared Statements පාවිච්චි කරයි
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
  }
  public static function store($name, $email)
  {
    $db = App::get('db');
    $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");

    $stmt->execute([
      'name' => $name,
      'email' => $email
    ]);
  }
}