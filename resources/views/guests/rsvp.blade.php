<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invitation — {{ $event->title }}</title>
    <!-- Google Fonts for High-End Luxurious Aesthetics -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind Play CDN (Guarantees perfect rendering on all public devices and phones!) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        accent: {
                            gold: '#d4af37',
                            champagne: '#f7e7ce',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background-color: #0b0f19;
        }
        .invitation-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 30px 70px -10px rgba(15, 10, 30, 0.4);
        }
        .ornament-border {
            position: relative;
        }
        .ornament-border::before {
            content: '';
            position: absolute;
            inset: 12px;
            border: 1px solid rgba(124, 58, 237, 0.15);
            pointer-events: none;
            border-radius: 12px;
        }
        .ornament-border::after {
            content: '';
            position: absolute;
            inset: 16px;
            border: 1px dashed rgba(212, 175, 55, 0.4);
            pointer-events: none;
            border-radius: 10px;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-purple-950/20 to-slate-950 flex items-center justify-center p-4 sm:p-6">

    <!-- Glowing Background Lights -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-brand-700/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-lg invitation-card rounded-2xl ornament-border p-8 sm:p-10 relative overflow-hidden text-center z-10">
        
        <!-- Elegant Top Golden Crown Ornament -->
        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 border border-brand-100 shadow-sm relative">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <p class="text-sm font-semibold tracking-[0.25em] text-brand-700 uppercase font-sans mb-2">You Are Cordially Invited</p>
        <div class="w-12 h-[1px] bg-gradient-to-r from-transparent via-brand-600 to-transparent mx-auto mb-6"></div>

        <!-- Breathtaking Serif Event Title -->
        <h1 class="font-serif text-4xl sm:text-5xl font-bold text-slate-900 leading-tight">{{ $event->title }}</h1>
        
        <div class="w-32 h-[1px] bg-gradient-to-r from-transparent via-accent-gold to-transparent mx-auto mt-6 mb-6"></div>

        <!-- Venue & Date info -->
        <div class="space-y-2 mb-8">
            <p class="text-lg text-slate-800 font-medium">
                {{ \Carbon\Carbon::parse($event->event_date)->format('l, F j, Y') }}
            </p>
            <p class="text-sm text-slate-500 font-sans tracking-wide flex items-center justify-center gap-1">
                <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                {{ $event->location }}
            </p>
        </div>

        <!-- Guest Details Panel -->
        <div class="p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-slate-100/50 border border-slate-100 shadow-sm max-w-sm mx-auto mb-8">
            <p class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Invitation For</p>
            <p class="font-serif text-2xl font-semibold text-slate-800 mt-1">{{ $guest->name }}</p>
            <p class="text-xs text-brand-600 font-medium mt-1 font-sans">Party size: {{ $guest->members }} {{ $guest->members == 1 ? 'Guest' : 'Guests' }}</p>
            
            <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-center gap-2">
                <span class="text-xs text-slate-400 font-sans">Current Status:</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold tracking-wide 
                    {{ $guest->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}
                    {{ $guest->status === 'declined' ? 'bg-rose-100 text-rose-800 border border-rose-200' : '' }}
                    {{ $guest->status === 'pending' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                ">
                    {{ ucfirst($guest->status) }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mt-6 p-4 rounded-xl border border-emerald-100 bg-emerald-50 text-sm text-emerald-800 font-medium shadow-sm max-w-sm mx-auto">
                <p class="flex items-center justify-center gap-1.5">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <!-- RSVP Form Options -->
        @if($guest->status === 'pending')
            <p class="text-sm text-slate-600 font-sans mb-4">Kindly respond to confirm your presence:</p>
            <div class="flex flex-col sm:flex-row gap-3 max-w-sm mx-auto">
                <form method="POST" action="/rsvp/{{ $guest->rsvp_token }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm shadow-md shadow-brand-500/10 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                        ✓ Accept
                    </button>
                </form>
                <form method="POST" action="/rsvp/{{ $guest->rsvp_token }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="status" value="declined">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 hover:border-slate-300 font-semibold text-sm shadow-sm transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                        Decline
                    </button>
                </form>
            </div>
        @else
            <div class="mt-8 border-t border-slate-100 pt-6">
                <p class="text-sm text-slate-400 italic">Thank you for submitting your response!</p>
                <p class="text-xs text-slate-400 mt-1">If you need to change your attendance details, please reach out to the event host.</p>
            </div>
        @endif
        
        <!-- Subtle Footer Ornament -->
        <div class="mt-10 flex justify-center gap-1.5 opacity-30">
            <div class="w-1.5 h-1.5 rounded-full bg-brand-600"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-accent-gold"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-brand-600"></div>
        </div>

    </div>
</body>
</html>
