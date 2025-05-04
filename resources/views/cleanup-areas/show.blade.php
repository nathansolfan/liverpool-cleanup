<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cleanup Area Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('cleanup-areas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to list
                        </a>
                    </div>

                    <!-- Title -->
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $cleanup->title }}</h3>

                    <!-- Status and Severity Badges -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                            @if($cleanup->status == 'completed') bg-green-100 text-green-800
                            @elseif($cleanup->status == 'scheduled') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            Status: {{ ucfirst($cleanup->status) }}
                        </span>
                        <span class="ml-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                            @if($cleanup->severity == 'high') bg-red-100 text-red-800
                            @elseif($cleanup->severity == 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            Severity: {{ ucfirst($cleanup->severity) }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Description</h4>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $cleanup->description ?? 'No description provided.' }}</p>
                    </div>

                    <!-- Location Map -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Location</h4>
                        <div id="cleanup-map" class="h-96 w-full rounded-lg border border-gray-300 bg-gray-100">
                            <!-- Map will load here -->
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Coordinates: {{ $cleanup->latitude }}, {{ $cleanup->longitude }}
                        </p>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Reported By</h4>
                            <p class="text-gray-600">{{ $cleanup->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Reported On</h4>
                            <p class="text-gray-600">{{ $cleanup->created_at ? $cleanup->created_at->format('F j, Y, g:i a') : 'Date not available' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('cleanup-areas.edit', $cleanup) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Edit
                        </a>
                        <form action="{{ route('cleanup-areas.destroy', $cleanup) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this cleanup area?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" defer></script>
    <script>
        function initMap() {
            // Get the cleanup area coordinates
            const location = { lat: {{ $cleanup->latitude }}, lng: {{ $cleanup->longitude }} };

            // Create the map centered at the cleanup area
            const map = new google.maps.Map(document.getElementById("cleanup-map"), {
                zoom: 15,
                center: location,
            });

            // Add a marker at the cleanup area location
            new google.maps.Marker({
                position: location,
                map: map,
                title: "{{ $cleanup->title }}"
            });
        }
    </script>
    @endpush
</x-app-layout>
