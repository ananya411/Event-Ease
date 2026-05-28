@extends('layouts.app')

@section('title', 'Create Event — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container max-w-3xl">
        <div class="ee-card">
            <div class="ee-card-header bg-slate-50/80">
                <h2 class="text-xl font-bold text-slate-900">Create New Event</h2>
                <a href="{{ route('events.index') }}" class="ee-btn-ghost ee-btn-sm">← Back</a>
            </div>
            <div class="ee-card-body">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div><label class="ee-label">Title</label><input type="text" name="title" class="ee-input" required value="{{ old('title') }}"></div>
                    <div><label class="ee-label">Event Type</label>
                        <select name="event_type" class="ee-input" required>
                            @foreach(['Wedding','Birthday','Corporate Event','Concert','Seminar','Engagement','Festival','Baby Shower','Anniversary','Custom Event'] as $type)
                                <option @selected(old('event_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label class="ee-label">Date</label><input type="date" name="event_date" class="ee-input" required value="{{ old('event_date') }}"></div>
                    <div class="relative">
                        <label class="ee-label">Location</label>
                        <div class="relative">
                            <input type="text" name="location" id="location-input" class="ee-input" autocomplete="off" required placeholder="Search hotels, venues, addresses..." value="{{ old('location') }}">
                            <!-- Loading Spinner icon -->
                            <div id="location-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                <svg class="animate-spin h-5 w-5 text-brand-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Suggestions Container -->
                        <div id="location-suggestions" class="absolute left-0 right-0 z-50 mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto divide-y divide-slate-100 hidden"></div>
                    </div>
                    <div><label class="ee-label">Budget (₹)</label><input type="number" name="budget" class="ee-input" min="0" required value="{{ old('budget') }}"></div>
                    <div>
                        <label class="ee-label">Event Banner</label>
                        <input type="file" name="banner" class="ee-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:font-semibold">
                        <p class="mt-1 text-xs text-slate-500">PNG, JPG up to 2MB</p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('events.index') }}" class="ee-btn-secondary">Cancel</a>
                        <button type="submit" class="ee-btn-primary">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Google Maps script loader (if key is configured in .env) -->
@if(env('GOOGLE_MAPS_API_KEY'))
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('location-input');
    var spinner = document.getElementById('location-spinner');
    var container = document.getElementById('location-suggestions');
    var debounceTimeout;

    if (!input) return;

    // 1. If Google Maps key is provided and loaded, initialize Google Autocomplete
    if (typeof google !== 'undefined' && google.maps && google.maps.places) {
        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['establishment', 'geocode']
        });
        return;
    }

    // 2. Free Autocomplete Fallback (Leaflet/OpenStreetMap Place Search)
    input.addEventListener('input', function() {
        clearTimeout(debounceTimeout);
        var query = input.value.trim();

        if (query.length < 3) {
            container.classList.add('hidden');
            return;
        }

        debounceTimeout = setTimeout(function() {
            if (spinner) spinner.classList.remove('hidden');

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=5')
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (spinner) spinner.classList.add('hidden');
                    container.innerHTML = '';

                    if (data && data.length > 0) {
                        data.forEach(function(item) {
                            var btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'w-full text-left px-4 py-3 text-sm hover:bg-slate-50 text-slate-700 font-sans transition flex items-start gap-2 border-0 bg-transparent cursor-pointer';
                            btn.innerHTML = '<svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> <span class="truncate">' + item.display_name + '</span>';
                            
                            btn.addEventListener('click', function() {
                                input.value = item.display_name;
                                container.classList.add('hidden');
                            });
                            
                            container.appendChild(btn);
                        });
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                })
                .catch(function() {
                    if (spinner) spinner.classList.add('hidden');
                });
        }, 300);
    });

    // Close recommendations dropdown on outside click
    document.addEventListener('click', function(e) {
        if (e.target !== input && e.target !== container && !container.contains(e.target)) {
            container.classList.add('hidden');
        }
    });
});
</script>
@endsection
