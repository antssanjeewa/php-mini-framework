<?php

namespace Core;

class Request
{
  public function query(?string $key = null, $default = null)
  {
    if ($key === null)
      return $_GET;
    return $_GET[$key] ?? $default;
  }

  public function input(?string $key = null, $default = null)
  {
    if ($key === null) {
      return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    }

    $value = $_POST[$key] ?? $default;
    return is_string($value) ? htmlspecialchars(trim($value)) : $value;
  }

  public function method(): string
  {
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }
  public function uri(): string
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }
}