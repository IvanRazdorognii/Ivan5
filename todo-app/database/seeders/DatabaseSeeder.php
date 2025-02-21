<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategorySeeder::class);

        // Create an admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Use a secure password
            'role' => 'admin',
        ]);
        // Create an user
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'), // Use a secure password
            'role' => 'user',
        ]);
    }
}