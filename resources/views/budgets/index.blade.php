@extends('layouts.app')

@section('title', 'Budget — ' . $event->title)

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header :title="$event->title . ' — Budget'" subtitle="Track spending against your event budget.">
            <x-slot name="actions">
                <a href="{{ route('events.index') }}" class="ee-btn-secondary ee-btn-sm">← Events</a>
                <a href="{{ route('budgets.create', $event->_id) }}" class="ee-btn-primary ee-btn-sm">+ Add Expense</a>
            </x-slot>
        </x-page-header>

        @php
            $spentPercent = $event->budget > 0 ? min(100, round(($totalSpent / $event->budget) * 100)) : 0;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="ee-stat">
                <p class="ee-stat-label">Total Budget</p>
                <p class="ee-stat-value">₹{{ number_format($event->budget) }}</p>
            </div>
            <div class="ee-stat">
                <p class="ee-stat-label">Total Spent</p>
                <p class="ee-stat-value text-rose-600">₹{{ number_format($totalSpent) }}</p>
            </div>
            <div class="ee-stat">
                <p class="ee-stat-label">Remaining</p>
                <p class="ee-stat-value {{ $remaining < 0 ? 'text-red-600' : 'text-emerald-600' }}">₹{{ number_format($remaining) }}</p>
            </div>
        </div>

        <div class="ee-card p-6 mb-8">
            <div class="flex justify-between text-sm mb-2">
                <span class="font-medium text-slate-700">Budget used</span>
                <span class="font-semibold text-brand-700">{{ $spentPercent }}%</span>
            </div>
            <div class="ee-progress-track">
                <div class="ee-progress-bar" style="width: {{ $spentPercent }}%"></div>
            </div>
        </div>

        <div class="ee-card">
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Notes</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($budgets as $budget)
                        <tr>
                            <td><span class="ee-badge-type">{{ $budget->category }}</span></td>
                            <td class="font-semibold text-rose-600">₹{{ number_format($budget->amount) }}</td>
                            <td class="text-slate-500">{{ \Carbon\Carbon::parse($budget->expense_date)->format('M d, Y') }}</td>
                            <td class="text-slate-500 max-w-xs truncate">{{ $budget->notes ?? '—' }}</td>
                            <td class="text-right">
                                <form action="{{ route('budgets.destroy', $budget->_id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this expense?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ee-btn-danger ee-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="ee-empty">No expenses logged yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
