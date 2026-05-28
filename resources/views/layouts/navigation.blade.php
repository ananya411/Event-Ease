@php
    $user = auth()->user();
    $homeRoute = $user
        ? match ($user->role) {
            'admin' => route('admin.dashboard'),
            'vendor' => route('vendor.bookings'),
            default => route('dashboard'),
        }
        : url('/');
@endphp

<nav x-data="{ open: false, openNotif: false }" class="bg-white/70 backdrop-blur-xl border-b border-white/40 sticky top-0 z-40">
    <div class="ee-container">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ $homeRoute }}" class="flex items-center gap-2.5 group">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-white shadow-md shadow-brand-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="font-bold text-lg text-slate-900 group-hover:text-brand-700 transition">Event<span class="text-brand-600">Ease</span></span>
                </a>

                @auth
                <div class="hidden sm:flex items-center gap-1">
                    @if($user->role === 'planner')
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Dashboard</a>
                        <a href="{{ route('events.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('events.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Events</a>
                        <a href="{{ route('vendors.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('vendors.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Vendors</a>
                        <a href="{{ route('planner.bookings') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('planner.bookings') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Bookings</a>
                    @elseif($user->role === 'vendor')
                        <a href="{{ route('vendor.bookings') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('vendor.bookings') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Booking Requests</a>
                    @elseif($user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Admin Panel</a>
                    @endif
                </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
                    @php
                        $unread = $user->unreadNotifications;
                        $count = $unread->count();
                    @endphp

                    <div class="relative">
                        <button @click="openNotif = !openNotif" type="button" class="relative p-2 rounded-lg text-slate-500 hover:text-brand-700 hover:bg-brand-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($count > 0)
                                <span class="absolute top-0.5 right-0.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ $count }}</span>
                            @endif
                        </button>

                        <div x-show="openNotif" @click.outside="openNotif = false" x-transition
                             class="absolute right-0 mt-2 w-80 bg-white border border-slate-100 rounded-2xl shadow-card-hover z-50 overflow-hidden" style="display: none;">
                            <div class="px-4 py-3 border-b border-slate-100 font-semibold text-slate-800">Notifications</div>
                            <div class="max-h-64 overflow-y-auto">
                                @forelse($unread as $notification)
                                    <div class="px-4 py-3 border-b border-slate-50 text-sm hover:bg-slate-50">
                                        <p class="text-slate-700">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="mt-1">
                                            @csrf
                                            <button type="submit" class="text-brand-600 text-xs font-medium hover:underline">Mark as read</button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="p-4 text-sm text-slate-500">No new notifications</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 border border-slate-200">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-brand-700 font-semibold text-xs">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <span class="hidden md:inline">{{ $user->name }}</span>
                                <svg class="h-4 w-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="ee-btn-ghost ee-btn-sm">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ee-btn-primary ee-btn-sm">Get started</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = !open" type="button" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @auth
                @if($user->role === 'planner')
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Dashboard</a>
                    <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('events.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Events</a>
                    <a href="{{ route('vendors.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('vendors.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Vendors</a>
                    <a href="{{ route('planner.bookings') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('planner.bookings') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Bookings</a>
                @elseif($user->role === 'vendor')
                    <a href="{{ route('vendor.bookings') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600">Booking Requests</a>
                @elseif($user->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600">Admin Panel</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
