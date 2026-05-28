@extends('layouts.app')

@section('title', 'Booking Requests — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header title="Booking Requests" subtitle="Review and respond to planner requests." />

        <div class="ee-card">
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Planner</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        @php
                            $event = $events[$booking->event_id] ?? null;
                            $planner = $planners[$booking->planner_id] ?? null;
                        @endphp
                        <tr>
                            <td class="font-medium">{{ $event->title ?? '—' }}</td>
                            <td class="text-slate-600">{{ $planner->name ?? '—' }}</td>
                            <td class="text-slate-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                            <td><span class="ee-badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                            <td>
                                <form action="{{ route('bookings.status', $booking->_id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="ee-input py-1.5 text-xs max-w-[140px]">
                                        @foreach(['pending','accepted','rejected','completed'] as $status)
                                            <option value="{{ $status }}" @selected($booking->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="ee-empty">No booking requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
