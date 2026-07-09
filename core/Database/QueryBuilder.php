<?php

namespace Core\Database;

use PDO;

class QueryBuilder
{
  protected PDO $db;
  protected string $table;
  protected string $model;
  protected array $fields = ['*'];
  protected array $wheres = [];
  protected array $bindings = [];
  protected string $orderBy = '';
  protected int|null $limit = null;

  public function __construct()
  {
    $this->db = app('db');
  }

  public function table(string $table): self
  {
    $this->table = $table;
    return $this;
  }

  public function setModel(string $model)
  {
    $this->model = $model;
  }

  public function select(array $fields): self
  {
    $this->fields = $fields;
    return $this;
  }

  public function where(string $field, string $operator, $value = null): self
  {
    if ($value === null) {
      $value = $operator;
      $operator = '=';
    }

    $this->wheres[] = "$field $operator ?";
    $this->bindings[] = $value;
    return $this;
  }

  public function orderBy(string $key, string $order = 'ASC'): self
  {
    $this->orderBy = "$key $order";
    return $this;
  }

  public function limit(int $limit): self
  {
    $this->limit = $limit;
    return $this;
  }

  public function get()
  {
    $query = $this->buildSelect();
    $stmt = $this->db->prepare($query);
    $stmt->execute($this->bindings);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $models = [];
    foreach ($data as $item) {
      $models[] = $this->hydrate($item);
    }
    return $models;
  }

  public function first()
  {
    $this->limit(1);
    $query = $this->buildSelect();
    $stmt = $this->db->prepare($query);
    $stmt->execute($this->bindings);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
      return null;
    }

    return $this->hydrate($data);
  }

  public function insert(array $data)
  {
    $columns = implode(',', array_keys($data));
    $placeholder = implode(',', array_map(fn() => '?', $data));
    $values = array_values($data);

    $query = "INSERT INTO $this->table ($columns) VALUES ($placeholder)";
    $stmt = $this->db->prepare($query);
    return $stmt->execute($values);
  }

  public function update(array $data)
  {
    $columns = array_keys($data);
    $placeholder = implode(',', array_map(fn($col) => "$col = ?", $columns));
    $values = array_values($data);

    $query = "UPDATE $this->table SET $placeholder";
    if ($this->wheres) {
      $query .= " WHERE " . implode(' AND ', $this->wheres);
    }

    $stmt = $this->db->prepare($query);
    return $stmt->execute([
      ...$values,
      ...$this->bindings
    ]);
  }

  public function delete()
  {
    $query = "DELETE FROM $this->table";
    if ($this->wheres) {
      $query .= " WHERE " . implode(' AND ', $this->wheres);
    }

    $stmt = $this->db->prepare($query);
    return $stmt->execute($this->bindings);
  }

  private function buildSelect(): string
  {
    $fields = implode(',', $this->fields);

    $query = "SELECT $fields FROM $this->table";

    if ($this->wheres) {
      $query .= " WHERE " . implode(' AND ', $this->wheres);
    }

    if ($this->orderBy) {
      $query .= " ORDER BY $this->orderBy";
    }

    if ($this->limit) {
      $query .= " LIMIT $this->limit";
    }

    return $query;
  }

  private function hydrate(array $data)
  {
    $model = new $this->model();
    foreach ($data as $key => $value) {
      $model->$key = $value;
    }
    return $model;
  }
}