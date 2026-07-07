<?php

namespace App\Controllers;

class UserController
{
  public function index()
  {
    return "<h1>User Page</h1>";
  }

  public function show($id)
  {
    return "<h1>User Profile Page</h1><p>දැනට පරීක්ෂා කරන පරිශීලකයාගේ අංකය (User ID) වන්නේ: <strong>{$id}</strong></p>";
  }
}