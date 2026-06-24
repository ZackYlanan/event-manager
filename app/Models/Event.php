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
        'cover_style',
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

    public function getCoverGradientAttribute(): string //getCoverGradientAttribute because cover_gradient
    {
        $covers = self::getAvailableCovers();

        // If the style exists in our array, return its gradient. Otherwise, return a fallback.
        return $covers[$this->cover_style]['gradient'] ?? 'bg-gradient-to-tr from-orange-400 to-amber-500';
    }
}
