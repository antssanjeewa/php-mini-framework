<?php

namespace App\Models;


class User
{
  public static function find(int $id)
  {
    $db = app('db');

    // SQL Injection වලින් ආරක්ෂා වීමට Prepared Statements පාවිච්චි කරයි
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
  }
  public static function store($name, $email)
  {
    $db = app('db');
    $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");

    $stmt->execute([
      'name' => $name,
      'email' => $email
    ]);
  }
}