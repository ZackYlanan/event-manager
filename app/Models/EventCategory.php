<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'display_name'
    ];


    // the category has many events

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
