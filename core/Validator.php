<?php

namespace Core;

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

        if ($rule === 'required' && empty($input)) {
          $this->addError($key, "{$key} එක අනිවාර්ය වේ!");
        }

        if ($rule === 'string' && is_string($input)) {
          $this->addError($key, "{$key} must be string!");
        }

        if ($rule === 'max' && strlen($input) > $ruleValue) {
          $this->addError($key, "{$key} exceep max length!");
        }

        if ($rule === 'email' && !empty($input) && !filter_var($input, FILTER_VALIDATE_EMAIL)) {
          $this->addError($key, "වලංගු Email ලිපිනයක් ඇතුළත් කරන්න!");
        }

        if ($rule === 'min' && !empty($input) && strlen($input) < $ruleValue) {
          $this->addError($key, "{$key} එකට අවම වශයෙන් අකුරු {$ruleValue} ක් අවශ්‍යයි!");
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
}