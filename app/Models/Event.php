<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'events';

    protected $fillable = [
        'user_id',
        'title',
        'event_type',
        'event_date',
        'location',
        'budget',
        'description',
        'status',
        'banner'
    ];

    protected $casts = [
        'budget' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);
}
}