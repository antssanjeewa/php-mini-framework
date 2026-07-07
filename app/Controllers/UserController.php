<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function index()
  {
    return view('user');
  }

  public function show($id)
  {
    $user = User::find($id);

    return view('user', ['id' => $id]);
  }

  public function store()
  {
    $formToken = $_POST['csrf_token'] ?? null;
    $sessionToken = $_SESSION['csrf_token'] ?? null;

    if (!$formToken || $formToken !== $sessionToken) {
      http_response_code(419); // 419 Page Expired (Laravel Standard)
      throw new \Exception("419 | CSRF Token Mismatch!");
    }

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;

    User::store($name, $email);
    // අපි දැනට මුල් පිටුවට (Home page) හරවා යවමු
    header('Location: /');
    exit;
  }
}