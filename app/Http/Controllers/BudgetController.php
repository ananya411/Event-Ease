<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Notifications\BookingNotification;

class BudgetController extends Controller
{
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);

        $budgets = Budget::where('event_id', $eventId)
                    ->latest()
                    ->get();

        $totalSpent = Budget::where('event_id', $eventId)
                        ->sum('amount');

        $remaining = $event->budget - $totalSpent;

        // ❌ REMOVED notification from here (prevents spam on refresh)

        return view('budgets.index', compact(
            'event',
            'budgets',
            'totalSpent',
            'remaining'
        ));
    }

    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        return view('budgets.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'category' => 'required',
            'amount' => 'required|numeric',
            'expense_date' => 'required',
        ]);

        Budget::create([
            'event_id' => $eventId,
            'category' => $request->category,
            'amount' => (float) $request->amount,
            'expense_date' => $request->expense_date,
            'notes' => $request->notes,
        ]);

        // ✔ Get event
        $event = Event::findOrFail($eventId);

        // ✔ Calculate updated budget
        $totalSpent = Budget::where('event_id', $eventId)->sum('amount');

        $remaining = $event->budget - $totalSpent;

        // ✔ Prevent repeated unnecessary notifications
        if ($remaining < 0 && $totalSpent > $event->budget) {

            auth()->user()->notify(
                new BookingNotification(
                    "Budget exceeded for event!"
                )
            );
        }

        return redirect()
            ->route('budgets.index', $eventId)
            ->with('success', 'Expense Added Successfully');
    }

    public function destroy($id)
    {
        Budget::findOrFail($id)->delete();

        return back();
    }
}