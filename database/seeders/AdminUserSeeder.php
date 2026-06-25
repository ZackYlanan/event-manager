<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User 1',
            'email' => 'admin1@pup.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin User 2',
            'email' => 'admin2@pup.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
