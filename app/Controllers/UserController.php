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
}