<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "Student $i",
                'email' => "student{$i}@iskolarngbayan.pup.edu.ph",
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => "2026-{$i}",
                'course' => "Course $i",
            ]);
        }
    }
}
