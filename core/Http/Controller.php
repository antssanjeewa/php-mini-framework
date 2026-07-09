<?php

namespace Core\Http;

class Controller
{
  public function view(string $viewName, array $data = [])
  {
    extract($data);
    ob_start();
    $viewFile = base_path("/views/{$viewName}.view.php");
    $status = Response::HTTP_OK;

    if (file_exists($viewFile)) {
      require $viewFile;
    } else {
      $status = Response::HTTP_NOT_FOUND;
      require base_path("/views/errors/404.view.php");
    }
    $viewContent = ob_get_clean();

    ob_start();
    require base_path("/views/layouts/main.view.php");
    $layoutContent = ob_get_clean();

    $html = str_replace('{{content}}', $viewContent, $layoutContent);

    return new Response($html, $status);
  }

  public function json(array $data)
  {
    return new Response(json_encode($data), Response::HTTP_OK, ['Content-Type: application/json']);
  }

  public function redirect(string|null $url = null)
  {
    if ($url === null)
      $url = $_SERVER['HTTP_REFERER'] ?? '/';

    return new Response('', Response::HTTP_REDIRECT, ["Location: {$url}"]);
  }
}