<?php
namespace Core;

use Core\Http\Response;
use Exception;

class ExceptionHandler
{
  public static function handle(Exception $e)
  {
    return new Response(view('errors/500', [
      'message' => $e->getMessage() . " (In " . $e->getFile() . " on line " . $e->getLine() . ")"
    ]), 500);
  }
}