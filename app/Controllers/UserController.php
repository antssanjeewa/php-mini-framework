<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\Request;

class UserController extends Controller
{
  public function index()
  {
    return $this->view('user');
  }

  public function show(Request $request, $id)
  {
    $user = User::find($id);

    return $this->view('user', ['id' => $id]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:50',
      'email' => 'required|min:6'
    ]);

    User::store($request->input('name'), $request->input('email'));

    return $this->redirect();
  }
}