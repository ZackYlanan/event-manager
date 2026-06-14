<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'description',
        'venue',
        'event_date',
        'start_time',
        'end_time',
        'maximum_slots',
        'registration_deadline',
        'status',
    ];

    protected $casts = [ // $cast automatically converts database values to specific PHP data types when retrieving them
        'event_date' => 'date',
        'registration_deadline' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id');
    }
}
