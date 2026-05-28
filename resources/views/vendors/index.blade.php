@extends('layouts.app')

@section('title', 'Find Vendors — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header title="Find Vendors" subtitle="Browse and book DJs, caterers, photographers, and more." />

        @auth
            @if(auth()->user()->role === 'planner' && $events->isNotEmpty())
            <div class="ee-card ee-card-body mb-6">
                <form method="GET" action="{{ route('vendors.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="ee-label">Book for event</label>
                        <select name="event_id" class="ee-input" onchange="this.form.submit()">
                            @foreach($events as $ev)
                                <option value="{{ $ev->_id }}" @selected($selectedEventId == $ev->_id)>{{ $ev->title }} — {{ \Carbon\Carbon::parse($ev->event_date)->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="vendor_type" value="{{ request('vendor_type') }}">
                    <input type="hidden" name="city" value="{{ request('city') }}">
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                </form>
            </div>
            @elseif(auth()->user()->role === 'planner')
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                Create an event first before booking vendors. <a href="{{ route('events.create') }}" class="font-semibold underline">Create event</a>
            </div>
            @endif
        @endauth

        <div class="ee-card ee-card-body mb-8">
            <form method="GET" action="{{ route('vendors.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @if($selectedEventId ?? false)
                    <input type="hidden" name="event_id" value="{{ $selectedEventId }}">
                @endif
                <div>
                    <label class="ee-label">Vendor type</label>
                    <input type="text" name="vendor_type" class="ee-input" placeholder="DJ, Caterer…" value="{{ request('vendor_type') }}">
                </div>
                <div>
                    <label class="ee-label">City</label>
                    <input type="text" name="city" class="ee-input" placeholder="City" value="{{ request('city') }}">
                </div>
                <div>
                    <label class="ee-label">Max price (₹)</label>
                    <input type="number" name="max_price" class="ee-input" placeholder="50000" value="{{ request('max_price') }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="ee-btn-primary w-full">Search</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vendors as $vendor)
            <article class="ee-card overflow-hidden hover:shadow-card-hover transition-shadow">
                <img src="{{ $vendor->banner_url }}" alt="{{ $vendor->name }}" class="w-full h-40 object-cover">
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-900">{{ $vendor->name }}</h3>
                    <p class="text-sm text-brand-600 font-medium mt-0.5">{{ $vendor->vendor_type }}</p>
                    <p class="text-sm text-slate-500 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $vendor->city }}
                    </p>
                    <p class="text-xl font-bold text-slate-900 mt-3">₹{{ number_format($vendor->price) }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        @auth
                            @if(auth()->user()->role === 'planner' && ($selectedEventId ?? false))
                                <a href="{{ route('bookings.create', [$selectedEventId, $vendor->_id]) }}" class="ee-btn-success w-full">Book Vendor</a>
                            @elseif(auth()->user()->role === 'planner')
                                <span class="block text-center text-sm text-slate-500">Select or create an event to book</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="ee-btn-primary w-full">Log in to book</a>
                        @endauth
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full ee-card ee-empty">No vendors match your filters. Try adjusting your search.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
