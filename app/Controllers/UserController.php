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
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;

    User::store($name, $email);

    redirect();
  }
}