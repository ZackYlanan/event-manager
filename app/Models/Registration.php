<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'full_name',
        'student_id',
        'email',
        'course',
        'registration_code',
        'attendance_status',
        'checked_in_at'
    ];

    // an registration belongs to one event

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
