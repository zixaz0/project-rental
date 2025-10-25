<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@rental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer account
        User::create([
            'name' => 'Customer',
            'email' => 'customer@rental.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}