<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::where('admin_id', auth()->id())->count(); // counts only the total events created by this specific admin

        $activeEvents = Event::where('admin_id', auth()->id())
            ->where('status', 'Published')
            ->where('event_date', '>=', now())
            ->count(); // counts only the active events created by this specific admin

        $totalStudents = User::where('role', 'student')->count(); // counts all the students in the system

        $totalTickets = Registration::whereHas('event', function ($query) {
            $query->where('admin_id', auth()->id());
        })->count(); // counts all the tickets/registrations of this specific admin

        // gets the next 4 upcoming events for the quick-view list (max of 4)
        $recentEvents = Event::withCount('registrations')
            ->where('admin_id', auth()->id()) // gets only the events created by this specific admin
            ->where('status', 'Published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'activeEvents',
            'totalStudents',
            'totalTickets',
            'recentEvents'
        ));
    }
}
