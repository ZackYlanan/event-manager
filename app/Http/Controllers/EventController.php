<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')
                    ->where('status', 'Published')
                    ->get(); // fetch all published events 

        return response()->json($events);
    }
}
