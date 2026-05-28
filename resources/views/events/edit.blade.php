@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h2 class="text-xl font-bold text-gray-800">Edit Event</h2>
                <a href="{{ route('events.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Back to Events</a>
            </div>

            <div class="p-6">
                <form action="{{ route('events.update', $event->_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ $event->title }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                        <select name="event_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="Wedding" {{ $event->event_type == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                            <option value="Birthday" {{ $event->event_type == 'Birthday' ? 'selected' : '' }}>Birthday</option>
                            <option value="Corporate Event" {{ $event->event_type == 'Corporate Event' ? 'selected' : '' }}>Corporate Event</option>
                            <option value="Concert" {{ $event->event_type == 'Concert' ? 'selected' : '' }}>Concert</option>
                            <option value="Seminar" {{ $event->event_type == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Engagement" {{ $event->event_type == 'Engagement' ? 'selected' : '' }}>Engagement</option>
                            <option value="Festival" {{ $event->event_type == 'Festival' ? 'selected' : '' }}>Festival</option>
                            <option value="Baby Shower" {{ $event->event_type == 'Baby Shower' ? 'selected' : '' }}>Baby Shower</option>
                            <option value="Anniversary" {{ $event->event_type == 'Anniversary' ? 'selected' : '' }}>Anniversary</option>
                            <option value="Custom Event" {{ $event->event_type == 'Custom Event' ? 'selected' : '' }}>Custom Event</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="event_date" value="{{ $event->event_date }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <div class="relative">
                            <input type="text" name="location" id="location-input" value="{{ $event->location }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" autocomplete="off" required placeholder="Search hotels, venues, addresses...">
                            <!-- Loading Spinner icon -->
                            <div id="location-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Suggestions Container -->
                        <div id="location-suggestions" class="absolute left-0 right-0 z-50 mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto divide-y divide-gray-100 hidden"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₹</span>
                            </div>
                            <input type="number" name="budget" value="{{ $event->budget }}" class="pl-7 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $event->description }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Banner</label>
                        @if($event->banner)
                            <img src="{{ asset('storage/'.$event->banner) }}" class="w-48 h-32 object-cover rounded-md shadow-sm mb-4">
                        @else
                            <p class="text-sm text-gray-500 mb-4 italic">No Banner Uploaded</p>
                        @endif

                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Banner</label>
                        <input type="file" name="banner" class="w-full border-gray-300 rounded-md shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                            Update Event
                        </button>
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
