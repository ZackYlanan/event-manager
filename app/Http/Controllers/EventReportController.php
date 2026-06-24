<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventReportController extends Controller
{
    public function showReport($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.report', compact('event'));
    }

    public function getReportData($id): JsonResponse

    {
        $event = Event::with(['registrations.user', 'category'])->findOrFail($id);

        $totalRegistrations = $event->registrations->count();
        $maxCapacity = $event->maximum_slots;

        $checkedIn = $event->registrations->where('attendance_status', 'Present')->count();
        $noShows = $totalRegistrations - $checkedIn; //absents

        /* $capacityUtilization = $maxCapacity > 0 ? round(($checkedIn / $maxCapacity) * 100, 2) : 0; */
        $capacityUtilization = $maxCapacity > 0 ? round(($totalRegistrations / $maxCapacity) * 100, 2) : 0;
        $turnoutRate = $totalRegistrations > 0 ? round(($checkedIn / $totalRegistrations) * 100, 2) : 0;

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

    public function exportCsv($id)
    {
        $event = Event::with('registrations.user')->findOrFail($id);
        $fileName = 'roster_event_' . $event->id . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => 0
        ];

        $callback = function () use ($event) {
            $file = fopen('php://output', 'w');

            // Calculate Analytics
            $totalRegistrations = $event->registrations->count();
            $maxCapacity = $event->maximum_slots;
            $checkedIn = $event->registrations->where('attendance_status', 'Present')->count();
            $noShows = $totalRegistrations - $checkedIn;

            $capacityUtilization = $maxCapacity > 0 ? round(($checkedIn / $maxCapacity) * 100, 2) : 0;
            $turnoutRate = $totalRegistrations > 0 ? round(($checkedIn / $totalRegistrations) * 100, 2) : 0;

            // Add BOM for proper UTF-8 Excel parsing
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

            fputcsv($file, ['Student Name', 'Student ID', 'Course', 'Registration Code', 'Attendance Status', 'Checked In At']);

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
