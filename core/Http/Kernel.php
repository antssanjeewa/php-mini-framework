<?php

namespace Core\Http;

use Core\ExceptionHandler;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\Router;
use Exception;

class Kernel
{

  public function handle(Request $request)
  {
    try {
      $router = app(Router::class);

      $response = $router->resolve($request);

      if ($response instanceof Response) {
        return $response;
      }
      return new Response($response);

    } catch (Exception $e) {
      return ExceptionHandler::handle($e);
    }
  }
}