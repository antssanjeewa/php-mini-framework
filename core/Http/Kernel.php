<?php

namespace Core\Http;

use Core\App;
use Core\Http\Request;
use Core\Routing\Router;

class Kernel
{

  public function handle(Request $request)
  {
    $router = App::get(Router::class);

    $response = $router->resolve($request);

    if ($response instanceof Response) {
      return $response;
    }
    return new Response($response);
  }
}