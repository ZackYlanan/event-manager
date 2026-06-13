<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'venue',
        'event_date',
        'start_time',
        'end_time',
        'max_slots',
        'registration_deadline',
        'status'
    ];

    // an event belongs to one admin (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // an event belongs to one category
    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    // an event has many Registrations (attendees)
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
