<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'total_bookings' => Booking::count(),
        ]);
    }

    public function users()
    {
        return User::all();
    }

    public function events()
    {
        return Event::all();
    }

    public function bookings()
    {
        return Booking::all();
    }
}