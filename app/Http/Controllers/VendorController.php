<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query();

        if ($request->vendor_type) {
            $query->where('vendor_type', 'like', '%' . $request->vendor_type . '%');
        }

        if ($request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->max_price) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        $vendors = $query->get();

        $events = collect();
        $selectedEventId = $request->get('event_id');

        if (auth()->check() && auth()->user()->role === 'planner') {
            $events = Event::where('user_id', auth()->id())
                ->orderBy('event_date', 'asc')
                ->get();

            if (!$selectedEventId && $events->isNotEmpty()) {
                $selectedEventId = $events->first()->_id;
            }
        }

        return view('vendors.index', compact('vendors', 'events', 'selectedEventId'));
    }
}
