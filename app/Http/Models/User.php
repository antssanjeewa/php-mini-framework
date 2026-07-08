<?php

namespace App\Http\Models;

use Core\Database\Model;

class User extends Model
{
  protected string $table = 'users';

  protected array $fillable = ['name', 'email'];
}