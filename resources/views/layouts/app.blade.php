<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EventEase'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Glassmorphism Theme Overrides -->
    <style>
        .ee-card {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(24px) saturate(120%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(120%) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 8px 32px 0 rgba(148, 163, 184, 0.05) !important;
        }
        .ee-card:hover {
            background: rgba(255, 255, 255, 0.6) !important;
            border-color: rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 20px 40px -8px rgba(99, 102, 241, 0.1), 0 10px 20px -6px rgba(0, 0, 0, 0.02) !important;
            transform: translateY(-2px) !important;
        }
        .ee-card-header {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.05)) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        .ee-table thead {
            background: rgba(255, 255, 255, 0.25) !important;
            backdrop-filter: blur(8px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.35) !important;
        }
        nav {
            background: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(20px) saturate(110%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(110%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.4) !important;
        }
        body {
            position: relative;
        }
    </style>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-slate-50 via-white to-brand-50/40 relative overflow-x-hidden">
    <!-- Ambient Background Glowing Orbs for Glassmorphism -->
    <div class="absolute top-[10%] left-[5%] w-[35rem] h-[35rem] rounded-full bg-gradient-to-br from-indigo-300/10 to-brand-300/5 blur-[120px] pointer-events-none -z-10 animate-pulse" style="animation-duration: 10s;"></div>
    <div class="absolute top-[40%] right-[5%] w-[40rem] h-[40rem] rounded-full bg-gradient-to-tr from-brand-300/10 to-rose-300/5 blur-[130px] pointer-events-none -z-10 animate-pulse" style="animation-duration: 15s;"></div>
    <div class="absolute bottom-[10%] left-[10%] w-[30rem] h-[30rem] rounded-full bg-gradient-to-tr from-violet-300/10 to-indigo-300/5 blur-[110px] pointer-events-none -z-10 animate-pulse" style="animation-duration: 12s;"></div>
    @include('layouts.navigation')

    @if (session('success') || session('error') || $errors->any())
        <div class="ee-container pt-4">
            @if (session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 flex items-start gap-2">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <main>
        @yield('content', $slot ?? '')
    </main>
</body>
</html>
