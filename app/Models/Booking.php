<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'bookings';

    protected $fillable = [
        'event_id',
        'vendor_id',
        'planner_id',
        'booking_date',
        'message',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function planner()
    {
        return $this->belongsTo(User::class, 'planner_id');
    }
}