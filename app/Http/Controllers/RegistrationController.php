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

        // Sort: "Pending" (upcoming) tickets on top, completed/absent tickets below
        $registrations = $registrations->sortByDesc(function ($registration) {
            return $registration->attendance_status === 'Pending';
        })->values();

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

    public function showCheckInForm(Request $request)
    {
        /* $activeEvents = Event::whereDate('event_date', today()) // only fetch the events happening today
            ->where('status', 'Published')
            ->orderBy('event_date', 'asc')
            ->get(); */

        $activeEvents = Event::whereBetween('event_date', [now(), now()->addDays(3)])
            ->where('admin_id', Auth::id())
            ->where('status', 'Published')
            ->orderBy('event_date', 'asc')
            ->get();

        $selectedEvent = null;
        $registrations = collect();

        if ($request->has('event_id')) {
            $selectedEvent = Event::where('admin_id', Auth::id())->findOrFail($request->event_id);

            $registrations = Registration::with('user', 'event')
                ->where('event_id', $selectedEvent->id)
                ->get();
        }

        return view('admin.checkin', compact('activeEvents', 'selectedEvent', 'registrations'));
    }

    public function processCheckIn(Request $request)
    {
        // to ensure that admin doesnt submit an empty input in the check in form
        $request->validate([
            'registration_code' => ['required', 'string', 'max:20']
        ]);

        // this search the matching ticket from the submit registration code
        // strtoupper just in case the scanner submits lowercase letters
        $registration = Registration::where('registration_code', strtoupper($request->registration_code))
            ->where('event_id', $request->event_id)
            ->first();

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

    public function cancelTicket($id)
    {
        $registration = Registration::where('user_id', Auth::id())->findOrFail($id);

        if ($registration->attendance_status !== 'Pending') {
            return redirect()->back()->with('error', 'You can only cancel pending tickets.');
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Ticket successfully cancelled.');
    }

    public function manualCheckIn(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->attendance_status === "Present") {
            return redirect()->back()->with('error', "Student already checked in!");
        }

        $registration->attendance_status = "Present";
        $registration->checked_in_at = now();
        $registration->save();

        return redirect()->back()->with('success', "Manually checked in {$registration->user->name}!");
    }
}
