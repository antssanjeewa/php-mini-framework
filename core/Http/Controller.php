<?php

namespace Core\Http;

class Controller
{
  public function view(string $viewName, array $data = [])
  {
    extract($data);
    ob_start();
    $viewFile = dirname(__DIR__) . "/../views/{$viewName}.view.php";

    if (file_exists($viewFile)) {
      require $viewFile;
    } else {
      require dirname(__DIR__) . "/../views/errors/404.view.php";
    }
    $viewContent = ob_get_clean();

    ob_start();
    require dirname(__DIR__) . "/../views/layouts/main.view.php";
    $layoutContent = ob_get_clean();

    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  public function json(array $data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }

  public function redirect(string|null $url = null)
  {
    if ($url === null)
      $url = $_SERVER['HTTP_REFERER'] ?? '/';

    header("Location: {$url}");
    exit;
  }
}