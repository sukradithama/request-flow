<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password',
            'role' => 'user',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'password',
            'role' => 'staff',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
