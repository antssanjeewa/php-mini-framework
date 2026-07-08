<?php

namespace Core\Database;

class Model
{
  protected static $db;
  protected string $table;
  protected array $fillable;

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

  protected function find($id)
  {

    $stmt = self::$db->prepare("SELECT * FROM $this->table WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
  }
  protected function all()
  {
    $stmt = self::$db->prepare("SELECT * FROM $this->table");
    $stmt->execute();

    return $stmt->fetchAll();
  }

  protected function create(array $data)
  {

    $values = array_intersect_key($data, array_flip($this->fillable));
    $columns = implode(',', array_keys($values));

    $placeholders = array_map(fn($col) => ":$col", array_keys($values));
    $placeholderString = implode(',', $placeholders);

    $stmt = self::$db->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholderString)");

    $stmt->execute($values);
  }

  protected function update(int $id, array $data)
  {

    $values = array_intersect_key($data, array_flip($this->fillable));

    $placeholders = array_map(fn($col) => "$col=:$col", array_keys($values));
    $placeholderString = implode(',', $placeholders);

    $stmt = self::$db->prepare("UPDATE $this->table SET $placeholderString WHERE id = :id");

    $values['id'] = $id;
    $stmt->execute($values);
  }

  protected function delete(int $id)
  {
    $stmt = self::$db->prepare("DELETE FROM $this->table WHERE id = :id");

    $stmt->execute(['id' => $id]);
  }
}