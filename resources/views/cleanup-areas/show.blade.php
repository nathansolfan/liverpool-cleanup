<x-app-layout>
    @push('styles')
    <style>
    #cleanup-map {
        height: 384px;
        width: 100%;
        z-index: 0;
    }
    </style>
    @endpush

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
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $cleanupArea->title }}</h3>

                    <!-- Status and Severity Badges -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                            @if($cleanupArea->status == 'completed') bg-green-100 text-green-800
                            @elseif($cleanupArea->status == 'scheduled') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            Status: {{ ucfirst($cleanupArea->status) }}
                        </span>
                        <span class="ml-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                            @if($cleanupArea->severity == 'high') bg-red-100 text-red-800
                            @elseif($cleanupArea->severity == 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            Severity: {{ ucfirst($cleanupArea->severity) }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Description</h4>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $cleanupArea->description ?? 'No description provided.' }}</p>
                    </div>

                    <!-- Location Map -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Location</h4>
                        <div id="cleanup-map" class="rounded-lg border border-gray-300 bg-gray-100">
                            <!-- Google Map will load here -->
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Coordinates: {{ $cleanupArea->latitude }}, {{ $cleanupArea->longitude }}
                        </p>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Reported Byyy</h4>
                            <p class="text-gray-600">{{ $cleanupArea->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Reported On</h4>
                            <p class="text-gray-600">{{ $cleanupArea->created_at ? $cleanupArea->created_at->format('F j, Y, g:i a') : 'Date not available' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        {{-- ONLY ALLOW USERS THAT CREATED REPORT TO UPDATE/DELETE --}}
                        @can('update', $cleanupArea)
                        <a href="{{ route('cleanup-areas.edit', $cleanupArea) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Edit
                        </a>
                        @endcan

                        {{-- ONLY ALLOW USERS THAT CREATED REPORT TO UPDATE/DELETE --}}
                        @can('delete', $cleanupArea)
                         <form action="{{ route('cleanup-areas.destroy', $cleanupArea) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this cleanup area?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Delete
                            </button>
                        </form>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function initMap() {
            // Get the cleanup area coordinates
            const location = { lat: {{ $cleanupArea->latitude }}, lng: {{ $cleanupArea->longitude }} };

            // Create the map centered at the cleanup area
            const map = new google.maps.Map(document.getElementById("cleanup-map"), {
                zoom: 15,
                center: location,
            });

            // Add a marker at the cleanup area location with custom color based on severity
            let markerColor = '#4CAF50'; // green for low
            if ('{{ $cleanupArea->severity }}' === 'high') markerColor = '#F44336'; // red
            else if ('{{ $cleanupArea->severity }}' === 'medium') markerColor = '#FF9800'; // orange

            const marker = new google.maps.Marker({
                position: location,
                map: map,
                title: "{{ $cleanupArea->title }}",
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/' +
                        (markerColor === '#F44336' ? 'red' :
                         markerColor === '#FF9800' ? 'orange' : 'green') + '-dot.png'
                }
            });

            // Add info window
            const infoWindow = new google.maps.InfoWindow({
                content: `<div style="padding: 10px;">
                            <h3 style="margin: 0; font-weight: bold;">{{ $cleanupArea->title }}</h3>
                            <p style="margin: 5px 0;">Severity: {{ ucfirst($cleanupArea->severity) }}</p>
                            <p style="margin: 5px 0;">Status: {{ ucfirst($cleanupArea->status) }}</p>
                          </div>`
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAHBjvzcG26iURd2HMx3Tf38hnE9EHeoA&callback=initMap" async defer></script>
    @endpush
</x-app-layout>
