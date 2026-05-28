@extends('layouts.app')

@section('title', 'My Bookings — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header title="My Vendor Bookings" subtitle="Track requests you've sent to vendors.">
            <x-slot name="actions">
                <a href="{{ route('vendors.index') }}" class="ee-btn-primary ee-btn-sm">Find vendors</a>
            </x-slot>
        </x-page-header>

        <div class="ee-card">
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Vendor</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        @php
                            $vendor = $vendors[$booking->vendor_id] ?? null;
                            $event = $events[$booking->event_id] ?? null;
                        @endphp
                        <tr>
                            <td class="font-medium">{{ $vendor->name ?? 'Unknown vendor' }}</td>
                            <td class="text-slate-600">{{ $event->title ?? '—' }}</td>
                            <td class="text-slate-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                            <td><span class="ee-badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                            <td class="text-right">
                                @if(in_array($booking->status, ['pending', 'accepted']))
                                <form action="{{ route('bookings.destroy', $booking->_id) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this booking?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ee-btn-danger ee-btn-sm">Cancel</button>
                                </form>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="ee-empty">No bookings yet. <a href="{{ route('vendors.index') }}" class="text-brand-600 font-medium hover:underline">Browse vendors</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
