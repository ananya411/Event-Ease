<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vendor;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\BookingNotification;
use App\Models\User;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Planner Booking List
    |--------------------------------------------------------------------------
    */
    public function plannerBookings()
    {
        $bookings = Booking::where('planner_id', auth()->id())
            ->latest()
            ->get();

        $vendorIds = $bookings->pluck('vendor_id')->unique()->filter();
        $eventIds = $bookings->pluck('event_id')->unique()->filter();

        $vendors = Vendor::whereIn('_id', $vendorIds)->get()->keyBy('_id');
        $events = Event::whereIn('_id', $eventIds)->get()->keyBy('_id');

        return view('bookings.planner', compact('bookings', 'vendors', 'events'));
    }

    /*
    |--------------------------------------------------------------------------
    | Vendor Booking List
    |--------------------------------------------------------------------------
    */
    public function vendorBookings()
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        if (!$vendor) {
            return back()->with('error', 'Vendor profile not found');
        }

        $bookings = Booking::where('vendor_id', $vendor->_id)
            ->latest()
            ->get();

        $eventIds = $bookings->pluck('event_id')->unique()->filter();
        $plannerIds = $bookings->pluck('planner_id')->unique()->filter();

        $events = Event::whereIn('_id', $eventIds)->get()->keyBy('_id');
        $planners = User::whereIn('_id', $plannerIds)->get()->keyBy('_id');

        return view('bookings.vendor', compact('bookings', 'events', 'planners'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Booking Form
    |--------------------------------------------------------------------------
    */
    public function create($eventId, $vendorId)
    {
        $event = Event::where('_id', $eventId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $vendor = Vendor::findOrFail($vendorId);

        return view('bookings.create', compact('event', 'vendor'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store Booking
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, $eventId, $vendorId)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'message' => 'required'
        ]);

        $exists = Booking::where('event_id', $eventId)
            ->where('vendor_id', $vendorId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vendor already booked for this event');
        }

        $alreadyBooked = Booking::where('vendor_id', $vendorId)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Vendor already booked for this date');
        }

        $booking = Booking::create([
            'event_id' => $eventId,
            'vendor_id' => $vendorId,
            'planner_id' => auth()->id(),
            'booking_date' => $request->booking_date,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        // NOTIFICATION: Planner
        auth()->user()->notify(new BookingNotification(
            "Your booking request has been sent successfully."
        ));

        // NOTIFICATION: Vendor User
        $vendor = Vendor::find($vendorId);

        if ($vendor && $vendor->user_id) {

            $vendorUser = User::find($vendor->user_id);

            if ($vendorUser) {
                $vendorUser->notify(new BookingNotification(
                    "You received a new booking request."
                ));
            }
        }

        return redirect()
            ->route('planner.bookings')
            ->with('success', 'Booking Request Sent Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Booking Status (IMPROVED)
    |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, $bookingId)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed'
        ]);

        $booking = Booking::findOrFail($bookingId);

        $booking->update([
            'status' => $request->status
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION: Planner (IMPROVED MESSAGE)
        |--------------------------------------------------------------------------
        */

        $planner = User::find($booking->planner_id);

        if ($planner) {

            $status = ucfirst($request->status);

            $message = match ($request->status) {

                'accepted' => "🎉 Good news! Your vendor has accepted the booking.",

                'rejected' => "❌ Sorry, your booking request was rejected.",

                'completed' => "✅ Your booking has been marked as completed.",

                default => "📌 Your booking status is now: {$status}",
            };

            $planner->notify(new BookingNotification($message));
        }

        return back()->with('success', 'Booking status updated');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Booking
    |--------------------------------------------------------------------------
    */
    public function destroy($bookingId)
    {
        Booking::findOrFail($bookingId)->delete();

        return back()->with('success', 'Booking deleted successfully');
    }
}