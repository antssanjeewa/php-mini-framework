<?php
namespace Core;

use Exception;

class ExceptionHandler
{
  public static function handle(Exception $e)
  {
    http_response_code(500);

    // 500 Error View එක ලෝඩ් කර විස්තර යැවීම
    echo view('errors/500', [
      'message' => $e->getMessage() . " (In " . $e->getFile() . " on line " . $e->getLine() . ")"
    ]);
    exit;
  }
}