<?php

namespace Database\Seeders;

use App\Models\User;
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
        $admin1 = User::where('email', 'admin1@pup.edu.ph')->first();
        $admin2 = User::where('email', 'admin2@pup.edu.ph')->first();

        // 10 events for admin 1
        for( $i = 1; $i <= 10; $i++ ) {
        DB::table('events')->insert([
                'admin_id' => $admin1->id,
                'category_id' => 1, 
                'title' => "Admin1 Event $i",
                'description' => "Description for Admin1 Event $i",
                'venue' => "Venue $i",
                'event_date' => Carbon::now()->addDays($i)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'maximum_slots' => 50,
                'registration_deadline' => Carbon::now()->addDays($i - 1)->toDateString(),
                'status' => 'Published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for($i = 2; $i <= 10; $i++){
            DB::table('events')->insert([
            'admin_id' => $admin2->id,
                'category_id' => 2,
                'title' => "Admin2 Event $i",
                'description' => "Description for Admin2 Event $i",
                'venue' => "Venue $i",
                'event_date' => Carbon::now()->addDays($i + 10)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '16:00:00',
                'maximum_slots' => 100,
                'registration_deadline' => Carbon::now()->addDays($i + 9)->toDateString(),
                'status' => 'Published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
        ]);
        }
    }
}
