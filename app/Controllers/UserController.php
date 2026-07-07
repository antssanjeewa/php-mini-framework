<?php

namespace App\Controllers;

class UserController
{
  public function index()
  {
    return view('user');
  }

  public function show($id)
  {
    return view('user', ['id' => $id]);
  }
}