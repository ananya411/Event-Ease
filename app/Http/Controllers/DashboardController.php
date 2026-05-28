<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Models\Budget;
use App\Models\Vendor;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Total Events
        |--------------------------------------------------------------------------
        */

        $totalEvents = Event::where('user_id', $userId)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Upcoming Events
        |--------------------------------------------------------------------------
        */

        $upcomingEvents = Event::where('user_id', $userId)
            ->where('event_date', '>=', now()->format('Y-m-d'))
            ->orderBy('event_date', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | User Events IDs
        |--------------------------------------------------------------------------
        */

        $eventIds = Event::where('user_id', $userId)
            ->pluck('id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Total Guests
        |--------------------------------------------------------------------------
        */

        $totalGuests = Guest::whereIn('event_id', $eventIds)
            ->sum('members');

        /*
        |--------------------------------------------------------------------------
        | Confirmed Guests
        |--------------------------------------------------------------------------
        */

        $confirmedGuests = Guest::whereIn('event_id', $eventIds)
            ->where('status', 'confirmed')
            ->sum('members');

        /*
        |--------------------------------------------------------------------------
        | Total Budget Spent
        |--------------------------------------------------------------------------
        */

        $totalSpent = Budget::whereIn('event_id', $eventIds)
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Recent Expenses
        |--------------------------------------------------------------------------
        */

        $recentExpenses = Budget::whereIn('event_id', $eventIds)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Events
        |--------------------------------------------------------------------------
        */

        $recentEvents = Event::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Expense Analytics
        |--------------------------------------------------------------------------
        */

        $expenseAnalytics = Budget::raw(function($collection) use ($eventIds) {

                return $collection->aggregate([

                    [
                        '$match' => [
                            'event_id' => [
                                '$in' => $eventIds
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => '$category',
                            'total' => [
                                '$sum' => '$amount'
                            ]
                        ]
                    ]

                ]);

            });

        /*
        |--------------------------------------------------------------------------
        | Event Type Analytics
        |--------------------------------------------------------------------------
        */

        $eventTypeAnalytics = Event::raw(function($collection) use ($userId) {

                return $collection->aggregate([

                    [
                        '$match' => [
                            'user_id' => $userId
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => '$event_type',
                            'count' => [
                                '$sum' => 1
                            ]
                        ]
                    ]

                ]);

            });

            $totalBookings = Booking::where('planner_id', $userId)->count();

$acceptedBookings = Booking::where('planner_id', $userId)
    ->where('status', 'accepted')
    ->count();

        return view('dashboard.index', compact(
            'totalEvents',
    'upcomingEvents',
    'totalGuests',
    'confirmedGuests',
    'totalSpent',
    'recentExpenses',
    'recentEvents',
    'expenseAnalytics',
    'eventTypeAnalytics',
    'totalBookings',
    'acceptedBookings'
        ));
    }
}