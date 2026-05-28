@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="ee-page">
    <div class="ee-container max-w-2xl">
        <x-page-header title="Add Expense" :subtitle="'For ' . $event->title">
            <x-slot name="actions">
                <a href="{{ route('budgets.index', $event->_id) }}" class="ee-btn-secondary ee-btn-sm">← Back</a>
            </x-slot>
        </x-page-header>

        <div class="ee-card ee-card-body">
            <form action="{{ route('budgets.store', $event->_id) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="ee-label">Category</label>
                    <select name="category" class="ee-input" required>
                        @foreach(['Catering','Decoration','Photography','Venue','Transport','Music','Other'] as $cat)
                            <option @selected(old('category') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ee-label">Amount (₹)</label>
                    <input type="number" name="amount" class="ee-input" min="1" required value="{{ old('amount') }}">
                </div>
                <div>
                    <label class="ee-label">Expense Date</label>
                    <input type="date" name="expense_date" class="ee-input" required value="{{ old('expense_date', date('Y-m-d')) }}">
                </div>
                <div>
                    <label class="ee-label">Notes</label>
                    <textarea name="notes" rows="3" class="ee-input">{{ old('notes') }}</textarea>
                </div>
                <div class="pt-2 flex justify-end gap-3">
                    <a href="{{ route('budgets.index', $event->_id) }}" class="ee-btn-secondary">Cancel</a>
                    <button type="submit" class="ee-btn-primary">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
