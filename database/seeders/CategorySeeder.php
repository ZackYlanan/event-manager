<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category' => 'workshop', 'display_name' => 'Technical Workshop'],
            ['category' => 'seminar', 'display_name' => 'Education Seminar'],
            ['category' => 'hackathon', 'display_name' => 'Hackathon Competition'],
            ['category' => 'meeting', 'display_name' => 'Organization Meeting'],
        ];

        foreach($categories as $category){
            EventCategory::create($category);
        }
    }
}
