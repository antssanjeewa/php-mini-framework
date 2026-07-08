<?php

use Core\Database\Migration;

class posts extends Migration
{
    public function up()
    {
        $db = \Core\Application::$app->db->pdo;
        // $sql = "CREATE TABLE ...";
        // $db->exec($sql);
    }

    public function down()
    {
        $db = \Core\Application::$app->db->pdo;
        // $sql = "DROP TABLE IF EXISTS ...";
        // $db->exec($sql);
    }
};