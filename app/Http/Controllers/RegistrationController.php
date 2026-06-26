<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    // Retrieve and display all tickets registered by the currently authenticated student
    public function myTickets() //(student)
    {
        // Load the associated event details for the student's tickets
        $registrations = Registration::with('event')->where('user_id', Auth::id())->get();

        // Sort the tickets: put 'Pending' (upcoming) tickets on top, and completed/absent tickets below
        $registrations = $registrations->sortByDesc(function ($registration) {
            return $registration->attendance_status === 'Pending';
        })->values();

        return view('student.tickets', compact('registrations'));
    }

    // Register a student for a specific event
    public function store(Request $request, $eventId) //(student)
    {
        // Fetch the event or fail with a 404 if it does not exist
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Restrict registration capability to users with the student role only
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Only students can register for events.');
        }

        // Prevents duplicate
        $alreadyRegistered = Registration::query()->where('event_id', $eventId)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->back()->with('error', 'You are already registered for this event!');
        }

        // Check if the event is full
        $currentRegistrations = Registration::query()->where('event_id', $eventId)->count();
        if ($currentRegistrations >= $event->maximum_slots) {
            return redirect()->back()->with('error', 'Sorry, this event is already full.');
        }

        // Create the registration ticket with a random, unique 8-character code
        Registration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'registration_code' => strtoupper(Str::random(8)),
            'attendance_status' => 'Pending',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Successfully registered for the event!');
    }

    public function cancel($id)
    {
        $registration = Registration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $event = $registration->event;

        // only allow cancel before registration_deadline
        if (now()->greaterThan($event->registration_deadline)) {
            return redirect()->back()->with('error', 'Cancellation period has ended.');
        }

        $registration->delete();

        return redirect()->route('tickets.index')->with('success', 'Your ticket has been cancelled.');
    }


    // Display the event check-in management page for admins
    public function showCheckInForm(Request $request) // (admin)
    {
        /* $activeEvents = Event::whereDate('event_date', today()) // only fetch the events happening today
            ->where('status', 'Published')
            ->orderBy('event_date', 'asc')
            ->get(); */

        $activeEvents = Event::query()->whereBetween('event_date', [now(), now()->addDays(3)])
            ->where('admin_id', Auth::id())
            ->where('status', 'Published')
            ->orderBy('event_date', 'asc')
            ->get();

        $selectedEvent = null;
        $registrations = collect();

        // If a specific event is selected from the dropdown, fetch its complete student roster
        if ($request->has('event_id')) {
            $selectedEvent = Event::query()->where('admin_id', Auth::id())->findOrFail($request->event_id);

            $registrations = Registration::query()->with('user', 'event')
                ->where('event_id', $selectedEvent->id)
                ->get();
        }

        return view('admin.checkin', compact('activeEvents', 'selectedEvent', 'registrations'));
    }

    // Process a student ticket check-in request
    public function processCheckIn(Request $request) //(admin)
    {
        // Ensure the registration code is provided in the input form
        $request->validate([
            'registration_code' => ['required', 'string', 'max:20']
        ]);

        // Search for a matching ticket using the submitted code, converting to uppercase for consistency
        $registration = Registration::query()->where('registration_code', strtoupper($request->registration_code))
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

        // Update the ticket status to 'Present' and record the current timestamp
        $registration->attendance_status = "Present";
        $registration->checked_in_at = now();
        $registration->save();

        // just for the alert message so we can see their name and the event title they have joined
        $studentName = $registration->user->name;
        $eventTitle = $registration->event->title;

        return redirect()->back()->with('success', "Successfully checked in {$studentName} for the event: \"{$eventTitle}\"!");
    }

    // Cancel a student's pending event ticket
    public function cancelTicket($id) //(student)
    {
        // Find the registration owned by the logged-in user
        $registration = Registration::query()->where('user_id', Auth::id())->findOrFail($id);

        // Restrict cancellations to pending tickets only (cannot cancel completed or absent tickets)
        if ($registration->attendance_status !== 'Pending') {
            return redirect()->back()->with('error', 'You can only cancel pending tickets.');
        }

        // Delete the registration record to free up the slot
        $registration->delete();

        return redirect()->back()->with('success', 'Ticket successfully cancelled.');
    }

    // Let the admin manually mark a student as present from the dashboard roster list
    public function manualCheckIn(Request $request, $id) //(admin)
    {
        $registration = Registration::findOrFail($id);

        // Verify that the student is not already marked as present
        if ($registration->attendance_status === "Present") {
            return redirect()->back()->with('error', "Student already checked in!");
        }

        // Update the status and checked-in timestamp
        $registration->attendance_status = "Present";
        $registration->checked_in_at = now();
        $registration->save();

        return redirect()->back()->with('success', "Manually checked in {$registration->user->name}!");
    }

    //sorting logic


}
