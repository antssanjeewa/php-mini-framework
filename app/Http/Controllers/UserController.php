<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Core\Http\Controller;
use Core\Http\Request;

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
    $data = $request->validate([
      'name' => 'required|string|max:50',
      'email' => 'required|min:6'
    ]);

    User::create($data);

    return $this->redirect();
  }
}