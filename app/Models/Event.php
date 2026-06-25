<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // The assignable attributes for the Event model
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
        'cover_style',
        'registration_deadline',
        'status',
    ];

    // This automattically convert specific columns to Carbon date objects
    protected $casts = [
        'event_date' => 'date',
        'registration_deadline' => 'date',
    ];

    // Relationship: An event belongs to the admin user who created it
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relationship: An event belongs to a single category (e.g., Hackathon, Seminar)
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    // Relationship: An event can have multiple student registration tickets
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id');
    }

    // Static helper for the cover styles
    public static function getAvailableCovers(): array
    {
        return [
            'sunset-glow' => [
                'label'    => 'Sunset Glow',
                'gradient' => 'bg-gradient-to-tr from-orange-400 via-pink-500 to-amber-300',
            ],
            'cosmic-midnight' => [
                'label'    => 'Cosmic Midnight',
                'gradient' => 'bg-gradient-to-br from-indigo-900 via-purple-800 to-pink-700',
            ],
            'cyberpunk-neon' => [
                'label'    => 'Cyberpunk Neon',
                'gradient' => 'bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-600',
            ],
            'forest-emerald' => [
                'label'    => 'Forest Emerald',
                'gradient' => 'bg-gradient-to-tr from-emerald-500 to-teal-700',
            ],
        ];
    }

    // Accessor: Get the CSS gradient class matching the event's selected cover style
    public function getCoverGradientAttribute(): string
    {
        $covers = self::getAvailableCovers();

        // Return the mapped gradient string or a default fallback orange gradient
        return $covers[$this->cover_style]['gradient'] ?? 'bg-gradient-to-tr from-orange-400 to-amber-500';
    }
}
