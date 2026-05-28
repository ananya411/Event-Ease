<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Mail\GuestInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\BookingNotification;

class GuestController extends Controller
{
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);

        $guests = Guest::where('event_id', $eventId)->get();

        foreach ($guests as $guest) {
            if (!$guest->rsvp_token) {
                $guest->update(['rsvp_token' => Str::random(40)]);
            }
        }

        $guests = Guest::where('event_id', $eventId)->get();

        return view('guests.index', compact('event', 'guests'));
    }

    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        return view('guests.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'members' => 'required|numeric',
        ]);

        $token = Str::random(40);

        $guest = Guest::create([
            'event_id' => $eventId,
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'members'  => (int) $request->members,
            'status'   => 'pending',
            'rsvp_token' => $token,
        ]);

        // Send RSVP invitation email if guest has an email address
        if ($guest->email) {
            $event = Event::findOrFail($eventId);
            try {
                Mail::to($guest->email)->send(new GuestInvitation($guest, $event));
            } catch (\Exception $e) {
                // Log mail failure but don't block the redirect
                logger()->error('Guest invitation email failed: ' . $e->getMessage());
            }
        }

        // In-app notification for planner
        auth()->user()->notify(
            new BookingNotification("Guest '{$request->name}' added to event")
        );

        return redirect()
            ->route('guests.index', $eventId)
            ->with('success', 'Guest Added! Invitation email sent to ' . ($request->email ?? 'guest') . '.');
    }

    public function updateStatus(Request $request, $guestId)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,declined',
        ]);

        $guest = Guest::findOrFail($guestId);

        if (!$guest->rsvp_token) {
            $guest->rsvp_token = Str::random(40);
        }

        $guest->update([
            'status' => $request->status,
            'rsvp_token' => $guest->rsvp_token,
        ]);

        // Notification on RSVP update
        auth()->user()->notify(
            new BookingNotification("Guest RSVP updated to: " . $request->status)
        );

        return back();
    }

    public function destroy($guestId)
    {
        Guest::findOrFail($guestId)->delete();

        return back();
    }
}