<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'registration_code',
        'attendance_status',
        'checked_in_at',
    ];

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

    public static function markAbsences()
    {
        $pendingRegistrations = self::with('event')->where('attendance_status', 'Pending')->get();

        foreach ($pendingRegistrations as $registration) {
            if ($registration->event) {
                $eventDateTime = \Carbon\Carbon::parse($registration->event->event_date->format('Y-m-d') . ' ' . $registration->event->end_time);

                if (now()->isAfter($eventDateTime)) {
                    $registration->attendance_status = 'Absent';
                    $registration->save();
                }
            }
        }
    }

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
