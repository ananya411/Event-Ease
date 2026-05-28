<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mb-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <a href="{{ route('events.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
           Create Event
        </a>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
