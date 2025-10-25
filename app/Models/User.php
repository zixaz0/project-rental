<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
 protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone',
    'address',
];

// Helper method buat cek role
public function isAdmin()
{
    return $this->role === 'admin';
}

public function isCustomer()
{
    return $this->role === 'customer';
}
}
