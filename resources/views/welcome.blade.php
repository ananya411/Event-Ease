<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventEase — Plan Events Without the Stress</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800">
    <header class="border-b border-slate-200/80 bg-white/90 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 font-bold text-lg">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                Event<span class="text-brand-600">Ease</span>
            </a>
            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'vendor' ? route('vendor.bookings') : route('dashboard')) }}" class="ee-btn-primary ee-btn-sm">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="ee-btn-ghost ee-btn-sm">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ee-btn-primary ee-btn-sm">Get started free</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-amber-50/40"></div>
        <div class="absolute top-20 right-0 w-72 h-72 bg-brand-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-10 w-96 h-96 bg-amber-200/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-16 pb-20 lg:pt-24 lg:pb-28">
            <div class="max-w-2xl">
                <p class="inline-flex items-center gap-2 rounded-full bg-brand-100 text-brand-800 text-xs font-semibold px-3 py-1 mb-6">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-600"></span>
                    Event planning made simple
                </p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight tracking-tight">
                    Plan unforgettable events, <span class="text-brand-600">all in one place</span>
                </h1>
                <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                    EventEase helps planners manage events, guests, budgets, and vendor bookings — with real-time notifications and a dashboard built for how you actually work.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="ee-btn-primary">Start planning</a>
                        <a href="{{ route('login') }}" class="ee-btn-secondary">Sign in</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="ee-btn-primary">Open dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16 lg:py-20">
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-slate-900 mb-4">Everything you need to run an event</h2>
        <p class="text-center text-slate-600 max-w-xl mx-auto mb-12">From the first guest list to the final vendor payment — stay organized at every step.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['title' => 'Events', 'desc' => 'Create and manage weddings, birthdays, corporate events, and more.', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['title' => 'Guest lists', 'desc' => 'Track RSVPs, party size, and confirmation status in one table.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['title' => 'Budget tracking', 'desc' => 'Log expenses by category and see remaining budget at a glance.', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title' => 'Vendor bookings', 'desc' => 'Find DJs, caterers, photographers and send booking requests.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ] as $feature)
            <div class="ee-card p-6 hover:shadow-card-hover transition-shadow">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 text-brand-700 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                </span>
                <h3 class="font-semibold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-slate-900 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Ready to plan your next event?</h2>
            <p class="text-slate-400 mb-8 max-w-lg mx-auto">Join as a planner, vendor, or admin — each role gets a tailored experience.</p>
            @guest
                <a href="{{ route('register') }}" class="ee-btn bg-white text-brand-700 hover:bg-brand-50 focus:ring-white">Create your account</a>
            @endguest
        </div>
    </section>

    <footer class="border-t border-slate-200 py-8 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} EventEase. Built for seamless event management.
    </footer>
</body>
</html>
