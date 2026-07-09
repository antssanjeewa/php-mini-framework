<?php

namespace Core\Console;

abstract class Command
{
  abstract public function execute(string|null $action, array $args);
}