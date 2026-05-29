@extends('layouts.app')

@section('title', 'Overview Dashboard — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <!-- Majestic Welcome Hero Board with Glowing Backlights -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-brand-950 px-8 py-10 text-white shadow-2xl mb-8 border border-white/10 animate-fade-in">
            <!-- Decorative Ambient Glowing Circles -->
            <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
            <div class="absolute -left-16 -bottom-16 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-brand-200">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-brand-400"></span> Live Coordinator Workspace
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-3">Welcome back, {{ auth()->user()->name }}! ✨</h1>
                    <p class="text-slate-200/90 text-sm mt-2 max-w-xl">Your event world is in perfect harmony. You are actively organizing {{ $totalEvents }} events, managing guest checklists, and orchestrating flawless memories.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-950 hover:bg-slate-50 transition shadow-lg shadow-black/10 active:scale-[0.98]">
                        📅 Plan New Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Operations Dock -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('events.create') }}" class="group p-5 bg-white rounded-2xl border border-slate-100 hover:border-indigo-100 shadow-sm hover:shadow-md transition-all flex flex-col items-start gap-4">
                <span class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Create Event</h4>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Plan a new occasion</p>
                </div>
            </a>
            <a href="{{ route('events.index') }}" class="group p-5 bg-white rounded-2xl border border-slate-100 hover:border-brand-100 shadow-sm hover:shadow-md transition-all flex flex-col items-start gap-4">
                <span class="p-3 bg-brand-50 text-brand-600 rounded-xl group-hover:bg-brand-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Manage Guests</h4>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Track invitations & RSVPs</p>
                </div>
            </a>
            <a href="{{ route('events.index') }}" class="group p-5 bg-white rounded-2xl border border-slate-100 hover:border-rose-100 shadow-sm hover:shadow-md transition-all flex flex-col items-start gap-4">
                <span class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Log Expenses</h4>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Budget tracker panel</p>
                </div>
            </a>
            <a href="{{ route('vendors.index') }}" class="group p-5 bg-white rounded-2xl border border-slate-100 hover:border-violet-100 shadow-sm hover:shadow-md transition-all flex flex-col items-start gap-4">
                <span class="p-3 bg-violet-50 text-violet-600 rounded-xl group-hover:bg-violet-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Book Vendors</h4>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Hire wedding & event pros</p>
                </div>
            </a>
        </div>

        <!-- Premium Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Stat: Total Events -->
            <div class="ee-stat border-l-indigo-600 bg-white/60 backdrop-blur-sm">
                <div>
                    <div class="flex justify-between items-start">
                        <p class="ee-stat-label">Total Events</p>
                        <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="ee-stat-value text-indigo-950">{{ $totalEvents }}</p>
                </div>
                <p class="text-[11px] text-slate-400 font-semibold mt-4">Active & upcoming events</p>
            </div>

            <!-- Stat: Total Guests with RSVP Acceptance Progress -->
            <div class="ee-stat border-l-brand-500 bg-white/60 backdrop-blur-sm">
                <div>
                    <div class="flex justify-between items-start">
                        <p class="ee-stat-label">RSVP Tracker</p>
                        <span class="p-1.5 bg-brand-50 text-brand-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="ee-stat-value text-indigo-950">{{ $confirmedGuests }} <span class="text-sm font-semibold text-slate-400">/ {{ $totalGuests }}</span></p>
                </div>
                @php
                    $guestAcceptRate = $totalGuests > 0 ? min(100, round(($confirmedGuests / $totalGuests) * 100)) : 0;
                @endphp
                <div class="mt-4">
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                        <span>Acceptance Rate</span>
                        <span class="text-brand-600">{{ $guestAcceptRate }}%</span>
                    </div>
                    <div class="ee-progress-track h-1.5">
                        <div class="ee-progress-bar" style="width: {{ $guestAcceptRate }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Stat: Total Budget Spent -->
            <div class="ee-stat border-l-rose-500 bg-white/60 backdrop-blur-sm">
                <div>
                    <div class="flex justify-between items-start">
                        <p class="ee-stat-label">Total Expenses</p>
                        <span class="p-1.5 bg-rose-50 text-rose-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="ee-stat-value text-rose-600">₹{{ number_format($totalSpent) }}</p>
                </div>
                <p class="text-[11px] text-slate-400 font-semibold mt-4">Total spent across all events</p>
            </div>

            <!-- Stat: Booking Acceptance -->
            <div class="ee-stat border-l-violet-500 bg-white/60 backdrop-blur-sm">
                <div>
                    <div class="flex justify-between items-start">
                        <p class="ee-stat-label">Vendor Bookings</p>
                        <span class="p-1.5 bg-violet-50 text-violet-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </span>
                    </div>
                    <p class="ee-stat-value text-violet-700">{{ $acceptedBookings }} <span class="text-sm font-semibold text-slate-400">/ {{ $totalBookings }}</span></p>
                </div>
                @php
                    $bookingConfirmPercent = $totalBookings > 0 ? min(100, round(($acceptedBookings / $totalBookings) * 100)) : 0;
                @endphp
                <div class="mt-4">
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                        <span>Confirmation Rate</span>
                        <span class="text-violet-600">{{ $bookingConfirmPercent }}%</span>
                    </div>
                    <div class="ee-progress-track h-1.5">
                        <div class="ee-progress-bar bg-gradient-to-r from-violet-500 to-indigo-600" style="width: {{ $bookingConfirmPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Upcoming Schedule Grid with Beautiful Cover Images -->
        <div class="mb-10 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div>
                        <h2 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Upcoming Schedule</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Your live timeline of upcoming events</p>
                    </div>
                </div>
                <a href="{{ route('events.index') }}" class="text-xs font-bold uppercase tracking-wider text-indigo-600 hover:text-indigo-800 transition">View All Events →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($upcomingEvents as $event)
                    @php
                        // Elegant high-fidelity Unsplash illustrations based on Event Type
                        $coverImage = $event->banner ? asset('storage/' . $event->banner) : match ($event->event_type) {
                            'Wedding' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=600&q=80',
                            'Birthday' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=600&q=80',
                            'Corporate Event' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=600&q=80',
                            'Concert' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=600&q=80',
                            'Engagement' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=600&q=80',
                            'Anniversary' => 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&w=600&q=80',
                            default => 'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&w=600&q=80',
                        };

                        $eGuests = $event->guests;
                        $eTotal = $eGuests->sum('members');
                        $eConfirmed = $eGuests->where('status', 'confirmed')->sum('members');
                        $ePercent = $eTotal > 0 ? min(100, round(($eConfirmed / $eTotal) * 100)) : 0;
                    @endphp
                    
                    <div class="ee-card flex flex-col justify-between group h-full">
                        <div>
                            <!-- Cover Banner with Date Overlay -->
                            <div class="relative h-44 w-full overflow-hidden">
                                <img src="{{ $coverImage }}" alt="{{ $event->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                                
                                <!-- Floating Type Badge -->
                                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 text-slate-800 shadow-sm border border-slate-100">
                                    {{ $event->event_type }}
                                </span>
                                
                                <!-- Date overlay badge -->
                                <div class="absolute bottom-4 left-4 text-white">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-indigo-200">Date of Event</p>
                                    <p class="text-sm font-extrabold">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition leading-tight">{{ $event->title }}</h3>
                                
                                {{-- Info Chips Row --}}
                                @php
                                    $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($event->event_date), false);
                                    $daysLabel = $daysLeft > 0 ? $daysLeft . 'd away' : ($daysLeft == 0 ? 'Today!' : 'Past');
                                    $daysColor = $daysLeft > 30 ? 'bg-blue-50 text-blue-600' : ($daysLeft > 7 ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600');
                                @endphp
                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    {{-- Venue --}}
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-semibold max-w-[160px] truncate">
                                        <svg class="w-3 h-3 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </span>
                                    {{-- Days countdown --}}
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg {{ $daysColor }} text-[11px] font-bold">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $daysLabel }}
                                    </span>
                                    {{-- Guest count --}}
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 text-[11px] font-bold">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $eTotal }} guests
                                    </span>
                                </div>

                                <!-- Guest RSVP progress tracking -->
                                <div class="mt-6 pt-5 border-t border-slate-100">
                                    <div class="flex justify-between items-center text-xs font-bold mb-1.5">
                                        <span class="text-slate-500 uppercase tracking-wider">RSVP Attendance</span>
                                        <span class="text-indigo-600 font-extrabold">{{ $ePercent }}%</span>
                                    </div>
                                    <div class="ee-progress-track h-2">
                                        <div class="ee-progress-bar bg-gradient-to-r from-brand-500 to-indigo-600" style="width: {{ $ePercent }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-2">{{ $eConfirmed }} confirmed of {{ $eTotal }} guests</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer actions -->
                        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">Budget: ₹{{ number_format($event->budget) }}</span>
                            <a href="{{ route('events.index') }}" class="text-xs font-extrabold uppercase tracking-wider text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1">
                                Manage →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full ee-card p-12 text-center text-slate-400 font-medium flex flex-col items-center justify-center gap-3">
                        <span class="p-4 bg-indigo-50 text-indigo-500 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </span>
                        <div>
                            <p class="font-bold text-slate-700 text-sm">No upcoming events found</p>
                            <p class="text-xs text-slate-400 mt-1">Get started by creating your very first event schedule today!</p>
                        </div>
                        <a href="{{ route('events.create') }}" class="ee-btn-primary ee-btn-sm mt-3">+ Create Event</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Grid: Recent Details & Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Expenses -->
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="flex items-center gap-2">
                        <span class="p-1 bg-rose-50 text-rose-600 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Recent Expenses</h2>
                    </div>
                </div>
                <div class="ee-table-wrap">
                    <table class="ee-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Expense Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentExpenses as $expense)
                            @php
                                try {
                                    $expDate = $expense->expense_date
                                        ? \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y')
                                        : ($expense->created_at ? \Carbon\Carbon::parse($expense->created_at)->format('M d, Y') : '—');
                                } catch (\Exception $e) {
                                    $expDate = '—';
                                }
                            @endphp
                            <tr>
                                <td class="font-bold text-slate-900">{{ $expense->category }}</td>
                                <td class="font-bold text-rose-600">₹{{ number_format($expense->amount) }}</td>
                                <td class="text-slate-500 font-semibold">{{ $expDate }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="ee-empty">No expenses logged yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="flex items-center gap-2">
                        <span class="p-1 bg-brand-50 text-brand-600 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </span>
                        <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Recently Created</h2>
                    </div>
                </div>
                <div class="ee-table-wrap">
                    <table class="ee-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Budget Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEvents as $event)
                            <tr>
                                <td class="font-bold text-slate-900">{{ $event->title }}</td>
                                <td><span class="ee-badge-type">{{ $event->event_type }}</span></td>
                                <td class="font-bold text-emerald-600">₹{{ number_format($event->budget) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="ee-empty">No events created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section: Analytics and Categories -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Expense by Category with Visual Bar Aggregators -->
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="flex items-center gap-2">
                        <span class="p-1 bg-rose-50 text-rose-600 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </span>
                        <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Expense by Category</h2>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($expenseAnalytics as $analytics)
                        @php
                            $maxExpense = collect($expenseAnalytics)->max('total');
                            $expensePercentage = $maxExpense > 0 ? min(100, round(($analytics->total / $maxExpense) * 100)) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-1">
                                <span class="text-slate-800">{{ $analytics->_id }}</span>
                                <span class="text-rose-600">₹{{ number_format($analytics->total) }}</span>
                            </div>
                            <div class="ee-progress-track h-2">
                                <div class="ee-progress-bar bg-rose-500" style="width: {{ $expensePercentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-sm text-slate-400 font-medium">No expense analytics logged yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Events by Type -->
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="flex items-center gap-2">
                        <span class="p-1 bg-brand-50 text-brand-600 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </span>
                        <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Events by Type</h2>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($eventTypeAnalytics as $type)
                        @php
                            $maxType = collect($eventTypeAnalytics)->max('count');
                            $typePercentage = $maxType > 0 ? min(100, round(($type->count / $maxType) * 100)) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-1">
                                <span class="text-slate-800">{{ $type->_id }}</span>
                                <span class="text-brand-600">{{ $type->count }} {{ $type->count === 1 ? 'event' : 'events' }}</span>
                            </div>
                            <div class="ee-progress-track h-2">
                                <div class="ee-progress-bar" style="width: {{ $typePercentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-sm text-slate-400 font-medium">No event statistics available yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
