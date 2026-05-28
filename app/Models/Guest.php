<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Guest extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'guests';

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'status',
        'members',
        'rsvp_token',
    ];

    protected $casts = [
        'members' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}