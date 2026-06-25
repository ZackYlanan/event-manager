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
        $totalEvents = Event::count();

        $activeEvents = Event::where('event_date', '>=', now())->count();

        $totalStudents = User::where('role', 'student')->count();

        $totalTickets = Registration::count();

        // gets the next 3 upcoming events for the quick-view list
        $recentEvents = Event::withCount('registrations')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
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
