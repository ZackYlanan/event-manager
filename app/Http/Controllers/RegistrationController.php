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

    public function showCheckInForm()
    {
        return view('admin.checkin');
    }

    public function processCheckIn(Request $request)
    {
        // to ensure that admin doesnt submit an empty input in the check in form
        $request->validate([
            'registration_code' => ['required', 'string', 'max:20']
        ]);

        // this search the matching ticket from the submit registration code
        $registration = Registration::where('registration_code', $request->registration_code)->first();

        // checks if the registration code / ticket doesnt exist in our records
        if (!$registration) {
            return redirect()->back()->with('error', 'Invalid Ticket Code. No registration found.');
        }

        // check if the registration ocde is valid but has already checked in, so no duplicate entry
        if ($registration->attendance_status === "Present") {
            return redirect()->back()->with('error', "This student is already checked in! (Ticket: {$request->registration_code})");
        }


        $registration->attendance_status = "Present"; // updates the status to Present and save the date of check in
        $registration->checked_in_at = now();
        $registration->save();

        // just for the alert message so we can see their name and the event title they have joined
        $studentName = $registration->user->name;
        $eventTitle = $registration->event->title;

        return redirect()->back()->with('success', "Successfully checked in {$studentName} for the event: \"{$eventTitle}\"!");
    }
}
