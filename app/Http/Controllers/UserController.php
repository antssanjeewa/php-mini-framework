<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Core\Http\Controller;
use Core\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    return $this->view('user', ['users' => $users]);
  }

  public function show(Request $request, $id)
  {
    $user = User::find($id);

    return $this->view('user', ['user' => $user]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:50',
      'email' => 'required|min:6'
    ]);

    if ($request->input('id')) {
      User::update($request->input('id'), $data);
      session('success', 'Updated Successfully');
    } else {
      User::create($data);
      session('success', 'Created Successfully');
    }
    return $this->redirect('/user');
  }
}