<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Http\Request;

class GuestRsvpController extends Controller
{
    public function show(string $token)
    {
        $guest = Guest::where('rsvp_token', $token)->firstOrFail();
        $event = $guest->event;

        return view('guests.rsvp', compact('guest', 'event'));
    }

    public function respond(Request $request, string $token)
    {
        $request->validate([
            'status' => 'required|in:confirmed,declined',
        ]);

        $guest = Guest::where('rsvp_token', $token)->firstOrFail();

        $guest->update(['status' => $request->status]);

        $event = $guest->event;
        if ($event && $event->user_id) {
            $planner = User::find($event->user_id);
            if ($planner) {
                $planner->notify(new BookingNotification(
                    "{$guest->name} RSVP: " . ucfirst($request->status) . " for {$event->title}"
                ));
            }
        }

        return redirect()
            ->route('rsvp.show', $token)
            ->with('success', $request->status === 'confirmed'
                ? 'Thank you! Your attendance is confirmed.'
                : 'Your response has been recorded. We\'re sorry you can\'t make it.');
    }
}
