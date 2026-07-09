<?php

namespace Core\Database;

use PDO;

class Model
{
  protected static $db;
  protected string $table;
  protected array $fillable;

  protected array $attribute = [];

  public function __construct()
  {
    self::$db = app('db');
  }

  public static function __callStatic($method, $args)
  {
    $instance = new static();

    if (method_exists($instance, $method)) {
      return call_user_func_array([$instance, $method], $args);
    }
  }

  public function __get($name)
  {
    return $this->attribute[$name] ?? null;
  }

  public function __set($name, $value)
  {
    $this->attribute[$name] = $value;
  }

  protected function find($id)
  {

    $stmt = self::$db->prepare("SELECT * FROM $this->table WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return null;
    }

    $model = new static();
    $model->attribute = $data;
    return $model;

  }
  protected function all()
  {
    $stmt = self::$db->prepare("SELECT * FROM $this->table");
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $models = [];

    foreach ($rows as $row) {
      $model = new static();
      $model->attributes = $row;
      $models[] = $model;
    }

    return $models;
  }

  protected function create(array $data)
  {

    $values = array_intersect_key($data, array_flip($this->fillable));
    $columns = implode(',', array_keys($values));

    $placeholders = array_map(fn($col) => ":$col", array_keys($values));
    $placeholderString = implode(',', $placeholders);

    $stmt = self::$db->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholderString)");

    $stmt->execute($values);

    return $this->find(self::$db->lastInsertId());
  }

  protected function update(int $id, array $data)
  {

    $values = array_intersect_key($data, array_flip($this->fillable));

    $placeholders = array_map(fn($col) => "$col=:$col", array_keys($values));
    $placeholderString = implode(',', $placeholders);

    $stmt = self::$db->prepare("UPDATE $this->table SET $placeholderString WHERE id = :id");

    $values['id'] = $id;
    $stmt->execute($values);

    return $this->find($id);
  }

  protected function delete(int $id)
  {
    $stmt = self::$db->prepare("DELETE FROM $this->table WHERE id = :id");

    $stmt->execute(['id' => $id]);
  }

  protected function hasMany(string $relatedModel, string $foreignKey)
  {
    $instance = new $relatedModel();

    $stmt = self::$db->prepare("SELECT * FROM $instance->table WHERE $foreignKey = :id");
    $stmt->execute(['id' => $this->id]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $models = [];

    foreach ($rows as $row) {
      $model = new $relatedModel();
      $model->attributes = $row;
      $models[] = $model;
    }

    return $models;
  }

  protected function belongsTo(string $relatedModel, string $foreignId)
  {
    $instance = new $relatedModel();

    $stmt = self::$db->prepare("SELECT * FROM $instance->table WHERE id = :id");
    $stmt->execute(['id' => $foreignId]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    $instance->attributes = $row;
    return $instance;
  }

  protected function hasOne(string $relatedModel, string $foreignKey)
  {
    $instance = new $relatedModel();

    $stmt = self::$db->prepare("SELECT * FROM $instance->table WHERE $foreignKey = :id");
    $stmt->execute(['id' => $this->id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    $instance->attributes = $row;
    return $instance;
  }
}