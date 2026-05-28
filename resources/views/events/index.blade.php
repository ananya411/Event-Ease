@extends('layouts.app')

@section('title', 'My Events — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header title="My Events" subtitle="Manage all your events in one place.">
            <x-slot name="actions">
                <a href="{{ route('events.create') }}" class="ee-btn-primary">+ Create Event</a>
            </x-slot>
        </x-page-header>

        <!-- Elegant Location Filter -->
        <div class="ee-card p-6 mb-8 bg-white/80 backdrop-blur-md">
            <form method="GET" action="{{ route('events.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[280px]">
                    <label class="ee-label">Search / Filter by Location</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="location" class="ee-input pl-10" placeholder="Enter venue, city, or address..." value="{{ request('location') }}">
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="submit" class="ee-btn-primary ee-btn-sm py-3 px-6 rounded-xl">Search</button>
                    @if(request()->filled('location'))
                        <a href="{{ route('events.index') }}" class="ee-btn-secondary ee-btn-sm py-3 px-6 rounded-xl">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="ee-card">
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Banner</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Budget</th>
                            <th>Guests RSVP</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>
                                @if($event->banner)
                                    <img src="{{ asset('storage/'.$event->banner) }}" alt="" class="w-20 h-14 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-20 h-14 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">No image</div>
                                @endif
                            </td>
                            <td class="font-medium text-slate-900">{{ $event->title }}</td>
                            <td><span class="ee-badge-type">{{ $event->event_type }}</span></td>
                            <td class="text-slate-500">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                            <td class="font-semibold text-emerald-600">₹{{ number_format($event->budget) }}</td>
                            <td>
                                @php
                                    $eventGuests = $event->guests;
                                    $totalG = $eventGuests->sum('members');
                                    $confirmedG = $eventGuests->where('status', 'confirmed')->sum('members');
                                    $rsvpPercent = $totalG > 0 ? min(100, round(($confirmedG / $totalG) * 100)) : 0;
                                @endphp
                                <div class="flex flex-col gap-1.5 max-w-[150px]">
                                    <div class="flex justify-between text-xs font-semibold">
                                        <span class="text-indigo-600">{{ $confirmedG }} / {{ $totalG }} Confirmed</span>
                                        <span class="text-slate-400">{{ $rsvpPercent }}%</span>
                                    </div>
                                    <div class="ee-progress-track h-1.5">
                                        <div class="ee-progress-bar" style="width: {{ $rsvpPercent }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('events.edit', $event->_id) }}" class="ee-btn-secondary ee-btn-sm">Edit</a>
                                    <a href="{{ route('guests.index', $event->_id) }}" class="ee-btn-secondary ee-btn-sm">Guests</a>
                                    <a href="{{ route('budgets.index', $event->_id) }}" class="ee-btn-secondary ee-btn-sm">Budget</a>
                                    <form action="{{ route('events.destroy', $event->_id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ee-btn-danger ee-btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="ee-empty">
                                You haven't created any events yet.
                                <a href="{{ route('events.create') }}" class="text-brand-600 font-medium hover:underline ml-1">Create your first event</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
