<?php

namespace Core\Database;

use PDO;

/**
 * @method static \Core\Database\QueryBuilder table(string $table)
 * @method static \Core\Database\QueryBuilder setModel(string $model)
 * @method static \Core\Database\QueryBuilder where(string $column, string $operator, mixed $value = null)
 * @method static \Core\Database\QueryBuilder get()
 * @method static \Core\Database\QueryBuilder first()
 * @method static \Core\Database\QueryBuilder insert(array $data)
 * @method static \Core\Database\QueryBuilder update(array $data)
 */
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

    $builder = new QueryBuilder();
    $builder->table($instance->table);
    $builder->setModel(static::class);

    if (method_exists($builder, $method)) {
      return call_user_func_array([$builder, $method], $args);
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
    return static::where('id', $id)->first();
  }

  protected function all()
  {
    return static::get();
  }

  protected function create(array $data)
  {
    $values = array_intersect_key($data, array_flip($this->fillable));

    static::insert($values);

    return $this->find(self::$db->lastInsertId());
  }

  protected function update(int $id, array $data)
  {
    $values = array_intersect_key($data, array_flip($this->fillable));

    static::where('id', $id)->update($values);

    return $this->find($id);
  }

  protected function delete(int $id)
  {
    return static::where('id', $id)->delete();
  }

  protected function hasMany(string $relatedModel, string $foreignKey)
  {
    $instance = new $relatedModel();
    static::setModel($relatedModel);
    return static::table($instance->table)->where($foreignKey, $this->id)->get();
  }

  protected function belongsTo(string $relatedModel, string $foreignId)
  {
    $instance = new $relatedModel();
    static::setModel($relatedModel);
    return static::table($instance->table)->where('id', $foreignId)->first();
  }

  protected function hasOne(string $relatedModel, string $foreignKey)
  {
    $instance = new $relatedModel();
    static::setModel($relatedModel);
    return static::table($instance->table)->where($foreignKey, $this->id)->first();

  }
}