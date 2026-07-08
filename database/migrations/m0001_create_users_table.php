<?php

use Core\Database\Migration;

class m0001_create_users_table extends Migration
{
  public function up()
  {
    $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";

    $db = app('db');
    $db->exec($sql);
  }

  public function down()
  {
    $sql = "DROP TABLE IF EXISTS users;";

    $db = app('db');
    $db->exec($sql);
  }
}