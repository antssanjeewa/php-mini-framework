<?php

namespace App\Controllers;

use App\Models\User;
use Core\Request;

class UserController
{
  public function index()
  {
    return view('user');
  }

  public function show(Request $request, $id)
  {
    $user = User::find($id);

    return view('user', ['id' => $id]);
  }

  public function store(Request $request)
  {
    User::store($request->input('name'), $request->input('email'));

    redirect();
  }
}