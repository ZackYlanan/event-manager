<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@pup.edu',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'student_id' => null,
            'course' => null,
        ]);

        // create for categories

        EventCategory::insert([
            [
                'category' => 'hackathon',
                'display_name' => 'University Hackathon',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category' => 'seminar',
                'display_name' => 'Academic Seminar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category' => 'workshop',
                'display_name' => 'Skills Workshop',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
