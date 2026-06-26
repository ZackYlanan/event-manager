<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ensures attendance records stay accurate whenever the dashboard is accessed,
        // preventing past attendees from remaining in a "Pending" state indefinitely.
        Registration::markAbsences();

        // Limits event statistics to the currently authenticated admin so each 
        // administrator only sees data relevant to their own managed events.
        $totalEvents = Event::query()
            ->where('admin_id', Auth::id())
            ->count();

        // Only upcoming published events are considered active because draft, 
        // cancelled, or completed events should not appear in active metrics.
        $activeEvents = Event::query()->where('admin_id', Auth::id())
            ->where('status', 'Published')
            ->where('event_date', '>=', now())
            ->count();

        // Provides administrators with visibility into the current student population 
        // that can register for events.
        $totalStudents = User::query()
            ->where('role', 'student')
            ->count();

        // Measures overall participation across all events owned by the current admin 
        // to support dashboard analytics and reporting.
        $totalTickets = Registration::query()
            ->whereHas('event', function ($query) {
                $query->where('admin_id', Auth::id());
            })
            ->count();

        // Displays only (max of 4) upcoming events to keep the dashboard concise 
        // and focused on the events that require immediate attention.
        $recentEvents = Event::withCount('registrations')
            ->where('admin_id', Auth::id())
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
