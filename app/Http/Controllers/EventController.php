<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->where('admin_id', Auth::id())->get();

        return view('admin.events.index', compact('events')); // we will create this view later


    }

    public function create()
    {
        $categories = EventCategory::all();
        $covers = Event::getAvailableCovers();

        return view('admin.events.create', compact('categories', 'covers'));
    }

    public function store(Request $request)
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

        $validatedData['admin_id'] = Auth::id(); //add the id of admin that created this event

        // Create the event in the database using the Model
        Event::create($validatedData);

        Log::info('Event created successfully with data:', $validatedData);

        // Send the user back to the dashboard with a success message
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function publicDirectory(Request $request)
    {
        // get all events that is published and have not happened
        $query = Event::withCount('registrations')
            ->where('status', 'Published')
            /*  ->where('event_date', '>=', now()) */
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->get();
        $categories = EventCategory::all();

        return view('student.directory', compact('events', 'categories'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::all();
        $covers = Event::getAvailableCovers();
        return view('admin.events.edit', compact('event', 'categories', 'covers'));
    }

    public function update(Request $request, $id)
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

        $event = Event::findOrFail($id);
        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy($id) // delete function in event
    {
        $event = Event::findOrFail($id);

        /* //restrict for admin only
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Only Admins can delete events.');
        }
 */
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function show($id)
    {
        $event = Event::with('category')
            ->withCount('registrations')
            ->findOrFail($id);

        return view('student.show', compact('event'));
    }
}
