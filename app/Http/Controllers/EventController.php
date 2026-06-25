<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // Display a list of events created by the currently authenticated admin
    public function index() //(admin)
    {
        // Restricts event management to the authenticated admin's own events,
        // preventing visibility into events owned by other administrators.
        $events = Event::withCount('registrations')
            ->where('admin_id', Auth::id())
            ->get();

        return view('admin.events.index', compact('events'));
    }

    // Show the form for creating a new event
    public function create() //(admin)
    {
        // Categories and cover styles are loaded dynamically for future additions
        $categories = EventCategory::all();
        $covers = Event::getAvailableCovers();

        return view('admin.events.create', compact('categories', 'covers'));
    }

    // Store a newly created event in the database
    public function store(Request $request) ////(admin)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'maximum_slots' => 'required|integer|min:1',
            'cover_style' => 'required|string',
            'registration_deadline' => 'required|date|before_or_equal:event_date',
            'status' => 'required|string|in:Draft,Published,Cancelled,Completed',
        ]);

        // Attach the ID of the authenticated admin who is creating the event
        $validatedData['admin_id'] = Auth::id();

        // Create the event record in the database
        Event::create($validatedData);

        Log::info('Event created successfully with data:', $validatedData);

        // Send the user back to the dashboard with a success message
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    // Display the public event directory with category filtering for students/guests
    public function publicDirectory(Request $request) //(student)
    {
        // Students should only discover events that are published
        $query = Event::withCount('registrations')
            ->where('status', 'Published')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc');

        // Filter events by category if a category ID is present in the request query parameters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->get();
        $categories = EventCategory::all();

        return view('student.directory', compact('events', 'categories'));
    }

    public function edit($id) //(admin)
    {
        // Find the event by ID, ensuring the authenticated admin owns it
        $event = Event::query()
            ->where('admin_id', Auth::id())
            ->findOrFail($id);

        $categories = EventCategory::all();
        $covers = Event::getAvailableCovers();

        return view('admin.events.edit', compact('event', 'categories', 'covers'));
    }

    // Update the specified event in the database
    public function update(Request $request, $id) //(admin)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i,H:i:s',
            'end_time' => 'required|date_format:H:i,H:i:s|after:start_time',
            'maximum_slots' => 'required|integer|min:1',
            'cover_style' => 'required|string',
            'registration_deadline' => 'required|date|before_or_equal:event_date',
            'status' => 'required|string|in:Draft,Published,Cancelled,Completed',
        ]);

        // Find the event and ensure the admin has ownership before committing updates
        $event = Event::query()
            ->where('admin_id', Auth::id())
            ->findOrFail($id);
        $event->update($validatedData);

        // Redirect back to the admin events listing with a success message
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    // Remove the specified event from the database
    public function destroy($id) //(admin)
    {
        // Deletion is restricted to the event owner to maintain data integrity
        // and prevent unauthorized administrative actions.
        $event = Event::query()->where('admin_id', Auth::id())->findOrFail($id);

        /* //restrict for admin only
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Only Admins can delete events.');
        }
 */
        $event->delete();

        // Redirect back to the admin events listing with a success message
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    // Display details of a specific event for students and guests
    public function show($id) //(student, guest)
    {
        // Retrieve the event with its category and registration count
        $event = Event::with('category')
            ->withCount('registrations')
            ->findOrFail($id);

        return view('student.show', compact('event'));
    }

    // Display the student home/landing page featuring a subset of upcoming events
    public function studentHome(Request $request) //(student, guest)
    {
        // The homepage intentionally highlights only upcoming published events
        $query = Event::withCount('registrations')
            ->where('status', 'Published')
            /*  ->where('event_date', '>=', now()) */
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc');

        // Filter events by category if a category ID is present in the request
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Limits homepage content to keep the landing page focused and uncluttered.
        $events = $query->take(3)->get();
        $categories = EventCategory::all();

        return view('student.home', compact('events', 'categories'));
    }
}
