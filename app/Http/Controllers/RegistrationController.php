<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function myTickets()
    {
        $registrations = Registration::with('event')->where('user_id', Auth::id())->get();

        return view('student.tickets', compact('registrations'));
    }

    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        //restrict to student only 
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Only students can register for events.');
        }

        //prevents duplicate
        $alreadyRegistered = Registration::where('event_id', $eventId)
            ->where('user_id', $user->id)
            ->exists();

        // checks if the student is already registered
        if ($alreadyRegistered) {
            return redirect()->back()->with('error', 'You are already registered for this event!');
        }

        // check if the event is full
        $currentRegistrations = Registration::where('event_id', $eventId)->count();
        if ($currentRegistrations >= $event->maximum_slots) {
            return redirect()->back()->with('error', 'Sorry, this event is already full.');
        }

        // Create the registration ticket with a random 8-character unique code
        Registration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'registration_code' => strtoupper(Str::random(8)),
            'attendance_status' => 'Pending',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Successfully registered for the event!');
    }
}
