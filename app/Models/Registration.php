<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Assignable attributes for the Registration model
    protected $fillable = [
        'event_id',
        'user_id',
        'registration_code',
        'attendance_status',
        'checked_in_at',
    ];

    // Cast checked_in_at to a Carbon datetime object when retrieved
    protected $casts = [
        'checked_in_at' => 'datetime'
    ];


    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Enforces the attendance policy that students who never check in
    // before an event ends should automatically be marked as Absent.
    public static function markAbsences()
    {
        // Get all tickets that are still marked as 'Pending'
        $pendingRegistrations = self::with('event')
            ->where('attendance_status', 'Pending')
            ->get();

        foreach ($pendingRegistrations as $registration) {
            if ($registration->event) {
                // Combine the event date and end time to determine when the event finished
                $eventDateTime = \Carbon\Carbon::parse($registration->event->event_date->format('Y-m-d') . ' ' . $registration->event->end_time);

                // If current time is past the event completion, mark the student as Absent
                if (now()->isAfter($eventDateTime)) {
                    $registration->attendance_status = 'Absent';
                    $registration->save();
                }
            }
        }
    }

    // Accessor: Dynamically return 'Absent' if a pending ticket's event has already finished
    public function getAttendanceStatusAttribute($value)
    {
        if ($value === 'Pending' && $this->event) {
            // If the event has finished, automatically treat it as Absent
            $eventDateTime = \Carbon\Carbon::parse($this->event->event_date->format('Y-m-d') . ' ' . $this->event->end_time);
            if (now()->isAfter($eventDateTime)) {
                return 'Absent';
            }
        }
        return $value;
    }

    // This seperates internal status values from user-facing labels, 
    // allowing UI wording to change without affecting stored data.
    public function getDisplayStatusAttribute()
    {
        return match ($this->attendance_status) {
            'Pending' => 'Ready to Scan',
            'Present' => 'Checked In',
            'Absent'  => 'Missed Event',
            default   => 'Unknown',
        };
    }
}
