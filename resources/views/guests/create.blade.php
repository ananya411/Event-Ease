@extends('layouts.app')

@section('title', 'Add Guest')

@section('content')
<div class="ee-page">
    <div class="ee-container max-w-2xl">
        <x-page-header title="Add Guest" :subtitle="'For ' . $event->title">
            <x-slot name="actions">
                <a href="{{ route('guests.index', $event->_id) }}" class="ee-btn-secondary ee-btn-sm">← Back</a>
            </x-slot>
        </x-page-header>

        <div class="ee-card ee-card-body">
            <form action="{{ route('guests.store', $event->_id) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="ee-label">Name</label>
                    <input type="text" name="name" class="ee-input" required value="{{ old('name') }}">
                </div>
                <div>
                    <label class="ee-label">Email</label>
                    <input type="email" name="email" class="ee-input" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="ee-label">Phone</label>
                    <input type="text" name="phone" class="ee-input" value="{{ old('phone') }}">
                </div>
                <div>
                    <label class="ee-label">Total Members</label>
                    <input type="number" name="members" class="ee-input" min="1" value="{{ old('members', 1) }}" required>
                </div>
                <div class="pt-2 flex justify-end gap-3">
                    <a href="{{ route('guests.index', $event->_id) }}" class="ee-btn-secondary">Cancel</a>
                    <button type="submit" class="ee-btn-success">Save Guest</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
