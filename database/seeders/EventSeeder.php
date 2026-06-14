<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; //for time 

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //sample seeder
        DB::table('events')->insert([
            [
                'title' => 'Laravel Workshop',
                'description' => 'Hands-on workshop on Laravel basics.',
                'venue' => 'Room 101, IT Building',
                'event_date' => Carbon::now()->addDays(7)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'max_slots' => 50,
                'registration_deadline' => Carbon::now()->addDays(5),
                'status' => 'published',
                'category_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Data Science Seminar',
                'description' => 'Introduction to machine learning and data analysis.',
                'venue' => 'Auditorium',
                'event_date' => Carbon::now()->addDays(14)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '16:00:00',
                'max_slots' => 100,
                'registration_deadline' => Carbon::now()->addDays(10),
                'status' => 'published',
                'category_id' =>4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
