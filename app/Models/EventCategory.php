<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    // Assignable attributes for the EventCategory model
    protected $fillable = [
        'category',
        'display_name',
    ];

    // Relationship: A category can contain multiple event records
    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}
