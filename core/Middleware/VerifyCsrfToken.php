<?php

namespace Core\Middleware;

class VerifyCsrfToken implements MiddlewareInterface
{
  public function handle($next)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $formToken = $_POST['csrf_token'] ?? null;
      $sessionToken = csrf_token();

      if (!$formToken || $formToken !== $sessionToken) {
        http_response_code(419); // 419 Page Expired (Laravel Standard)
        throw new \Exception("419 | CSRF Token Mismatch!");
      }
    }

    return $next();
  }
}