<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Str;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch the first two events from the database.
        $events = Event::orderBy('id')->take(2)->get();

        // 2. Fetch exactly 49 users who have the 'student' role.
        $students = User::where('role', 'student')->take(49)->get();

        // 3. Loop through both of those events
        foreach ($events as $event) {
            // ...and inside that loop, loop through the 49 students.
            foreach ($students as $student) {
                // 4. Create a Registration for each student for both events.
                Registration::create([
                    'event_id' => $event->id,
                    'user_id' => $student->id,
                    'registration_code' => strtoupper(Str::random(8)),
                    'attendance_status' => 'Pending',
                ]);
            }
        }
    }
}
