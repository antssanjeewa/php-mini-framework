<?php

namespace Core;

abstract class ServiceProvider
{
  abstract public function register();
  abstract public function boot();
}