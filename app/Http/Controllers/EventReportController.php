<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventReportController extends Controller
{
    // Show the HTML report page for a specific event (only if owned by the logged-in admin)
    public function showReport($id)
    {
        // Fetch the event or fail if it does not exist or does not belong to the admin
        $event = Event::query()
            ->where('admin_id', Auth::id())
            ->findOrFail($id);

        return view('admin.report', compact('event'));
    }

    // Fetch analytics and student roster data in JSON format for dynamic frontend graphs/tables
    public function getReportData($id): JsonResponse
    {
        // Load category and registrations with their associated users
        $event = Event::with(['registrations.user', 'category'])
            ->where('admin_id', Auth::id())
            ->findOrFail($id);

        // Calculate analytics variables
        $totalRegistrations = $event->registrations->count();
        $maxCapacity = $event->maximum_slots;

        // Count how many students have checked in ('Present') and how many did not ('Absent' or 'Pending')
        $checkedIn = $event->registrations
            ->where('attendance_status', 'Present')
            ->count();
        $noShows = $totalRegistrations - $checkedIn; //absents

        // Calculate percentage calculations (avoiding division by zero)
        $capacityUtilization = $maxCapacity > 0 ? round(($totalRegistrations / $maxCapacity) * 100, 2) : 0;
        $turnoutRate = $totalRegistrations > 0 ? round(($checkedIn / $totalRegistrations) * 100, 2) : 0;

        // Map registrations to a clean list of student details
        $roster = $event->registrations->map(function ($registration) {
            return [
                'student_name' => $registration->user->name,
                'student_id' => $registration->user->student_id ?? 'N/A',
                'course' => $registration->user->course ?? 'N/A',
                'registration_code' => $registration->registration_code,
                'attendance_status' => $registration->attendance_status,
                'checked_in_at' => $registration->checked_in_at ? $registration->checked_in_at->toDateTimeString() : null,
            ];
        });

        // Return the gathered data as a JSON response
        return response()->json([
            'success' => 'true',
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'category' => $event->category->display_name ?? 'N/A',
                'maximum_slots' => $maxCapacity,
            ],
            'analytics' => [
                'total_registrations' => $totalRegistrations,
                'capacity_utilization' => $capacityUtilization . '%',
                'actual_attendance' => $checkedIn,
                'no_shows' => $noShows,
                'turnout_rate' => $turnoutRate . '%',
            ],
            'roster' => $roster,
        ], 200);
    }

    // Export the event analytics and registration roster to a downloadable CSV file
    public function exportCsv($id)
    {
        // Find the event and load all registration records
        $event = Event::with('registrations.user')
            ->where('admin_id', Auth::id())
            ->findOrFail($id);
        $fileName = 'roster_event_' . $event->id . '_' . now()->format('Y-m-d') . '.csv';

        // Set response headers for direct file download
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => 0
        ];

        // Stream the CSV writing process directly into the response stream
        $callback = function () use ($event) {
            $file = fopen('php://output', 'w');

            // Calculate Analytics
            $totalRegistrations = $event->registrations->count();
            $maxCapacity = $event->maximum_slots;
            $checkedIn = $event->registrations->where('attendance_status', 'Present')->count();
            $noShows = $totalRegistrations - $checkedIn;

            $capacityUtilization = $maxCapacity > 0 ? round(($checkedIn / $maxCapacity) * 100, 2) : 0;
            $turnoutRate = $totalRegistrations > 0 ? round(($checkedIn / $totalRegistrations) * 100, 2) : 0;

            // Add BOM (Byte Order Mark) for proper UTF-8 parsing inside Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write Analytics Header
            fputcsv($file, ['Event Analytics Report']);
            fputcsv($file, ['Event Title', $event->title]);
            fputcsv($file, ['Total Registrations', $totalRegistrations]);
            fputcsv($file, ['Capacity Utilization', $capacityUtilization . '%']);
            fputcsv($file, ['Actual Attendance', $checkedIn]);
            fputcsv($file, ['No Shows', $noShows]);
            fputcsv($file, ['Turnout Rate', $turnoutRate . '%']);
            fputcsv($file, []); // Empty row for spacing

            // Write table header for student roster listing
            fputcsv($file, ['Student Name', 'Student ID', 'Course', 'Registration Code', 'Attendance Status', 'Checked In At']);

            // Write registration details for each student
            foreach ($event->registrations as $reg) {
                fputcsv($file, [
                    $reg->user->name,
                    $reg->user->student_id ?? 'N/A',
                    $reg->user->course ?? 'N/A',
                    $reg->registration_code,
                    $reg->attendance_status,
                    $reg->checked_in_at ? $reg->checked_in_at->toDateTimeString() : 'Not Checked In'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
