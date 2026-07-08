<?php

namespace Core\Http;

class Validator
{

  private array $errors = [];

  public function validate(array $inputs, array $rules): bool
  {
    foreach ($rules as $key => $ruleString) {
      $fieldRules = explode('|', $ruleString);

      foreach ($fieldRules as $rule) {
        $ruleValue = null;

        if (strpos($rule, ':') !== false) {
          [$rule, $ruleValue] = explode(':', $rule);
        }

        $input = $inputs[$key] ?? null;

        $methodName = 'validate' . ucfirst($rule);

        if (method_exists($this, $methodName)) {
          $this->$methodName($key, $input, $ruleValue);
        }
      }
    }

    return empty($this->errors);
  }

  public function errors(): array
  {
    return $this->errors;
  }

  private function addError($key, $message)
  {
    $this->errors[$key][] = $message;
  }

  private function validateRequired($field, $value)
  {
    if (empty($value)) {
      $this->addError($field, "{$field} එක අනිවාර්ය වේ!");
    }
  }

  private function validateString($field, $value)
  {
    if (is_string($value)) {
      $this->addError($field, "{$field} must be string!");
    }
  }

  private function validateMax($field, $value, $ruleValue)
  {
    if (strlen($value) > $ruleValue) {
      $this->addError($field, "{$field} exceep max length!");
    }
  }

  private function validateEmail($field, $value)
  {
    if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->addError($field, "වලංගු Email ලිපිනයක් ඇතුළත් කරන්න!");
    }

  }

  private function validateMin($field, $value, $ruleValue)
  {
    if (!empty($value) && strlen($value) < $ruleValue) {
      $this->addError($field, "{$field} එකට අවම වශයෙන් අකුරු {$ruleValue} ක් අවශ්‍යයි!");
    }
  }
}