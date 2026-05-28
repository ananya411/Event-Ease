@extends('layouts.app')

@section('title', 'Book Vendor')

@section('content')
<div class="ee-page">
    <div class="ee-container max-w-2xl">
        <x-page-header title="Book Vendor" subtitle="Send a booking request to {{ $vendor->name }}.">
            <x-slot name="actions">
                <a href="{{ route('vendors.index', ['event_id' => $event->_id]) }}" class="ee-btn-secondary ee-btn-sm">← Back</a>
            </x-slot>
        </x-page-header>

        <div class="ee-card ee-card-body mb-6">
            <div class="flex gap-4 items-start">
                <img src="{{ $vendor->banner_url }}" alt="" class="w-24 h-24 rounded-xl object-cover">
                <div>
                    <h3 class="font-bold text-xl text-slate-900">{{ $vendor->name }}</h3>
                    <p class="text-brand-600 font-medium">{{ $vendor->vendor_type }}</p>
                    <p class="text-2xl font-bold mt-2">₹{{ number_format($vendor->price) }}</p>
                    <p class="text-sm text-slate-500 mt-1">Event: <strong>{{ $event->title }}</strong></p>
                </div>
            </div>
        </div>

        <div class="ee-card ee-card-body">
            <form action="{{ route('bookings.store', [$event->_id, $vendor->_id]) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="ee-label">Booking Date</label>
                    <input type="date" name="booking_date" class="ee-input" required min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}">
                </div>
                <div>
                    <label class="ee-label">Message to vendor</label>
                    <textarea name="message" rows="4" class="ee-input" required placeholder="Describe your requirements, timing, etc.">{{ old('message') }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('vendors.index', ['event_id' => $event->_id]) }}" class="ee-btn-secondary">Cancel</a>
                    <button type="submit" class="ee-btn-success">Send Booking Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
