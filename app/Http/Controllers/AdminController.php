<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Vendor;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPlanners = User::where('role', 'planner')->count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalEvents = Event::count();
        $totalBookings = Booking::count();

        $recentUsers = User::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalPlanners',
            'totalVendors',
            'totalEvents',
            'totalBookings',
            'recentUsers'
        ));
    }
}
