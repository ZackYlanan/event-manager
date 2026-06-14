<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('admin_id', Auth::id())->get();

        return view('admin.events.index', compact('events')); // we will create this view later


    }

    public function create()
    {
        $categories = EventCategory::all();

        return view('admin.events.create', compact('categories'));
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
            'registration_deadline' => 'required|date|before_or_equal:event_date',
        ]);

        $validatedData['admin_id'] = Auth::id(); //add the id of admin that created this event
        $validateData['status'] = 'Published'; //default on published for now

        // Create the event in the database using the Model
        Event::create($validatedData);

        // Send the user back to the dashboard with a success message
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }
}
