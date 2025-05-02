<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Locations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 text-right">
                         {{-- Add Links to create Building/Floor/Washroom --}}
                        <x-primary-button onclick="location.href='{{ route('admin.locations.create') }}'"> {{-- Adjust route if needed --}}
                            {{ __('Add Washroom') }}
                        </x-primary-button>
                    </div>
                    {{-- Placeholder for table listing Buildings, Floors, and Washrooms --}}
                    <p>{{ __("Location listing table goes here...") }}</p>
                     {{-- Use @foreach loops to display $buildings or $washrooms passed from controller --}}
                     {{-- Include links for edit/delete --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>