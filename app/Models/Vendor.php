<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/** @property-read User|null $user */

class Vendor extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'vendors';

    protected $fillable = [
        'user_id',
        'name',
        'vendor_type',
        'city',
        'price',
        'phone',
        'description',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getBannerUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        $type = strtolower($this->vendor_type ?? '');

        if (str_contains($type, 'dj')) {
            return 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($type, 'cater') || str_contains($type, 'food')) {
            return 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($type, 'photo') || str_contains($type, 'video') || str_contains($type, 'camera')) {
            return 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($type, 'decor') || str_contains($type, 'flower') || str_contains($type, 'stage')) {
            return 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($type, 'venue') || str_contains($type, 'hall') || str_contains($type, 'lawn')) {
            return 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80';
        }
        if (str_contains($type, 'music') || str_contains($type, 'band') || str_contains($type, 'sing') || str_contains($type, 'sound')) {
            return 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=800&q=80';
        }

        return 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80';
    }
}