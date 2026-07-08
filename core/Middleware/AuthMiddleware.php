<?php

namespace Core\Middleware;

class AuthMiddleware implements MiddlewareInterface
{

  public function handle($next)
  {
    // if (!isset($_SESSION['user'])) {
    //   header('Location: /login');
    //   exit;
    // }

    return $next();
  }
}