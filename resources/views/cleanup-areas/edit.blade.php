<x-app-layout>
    @push('styles')
    <style>
    #edit-map {
        height: 384px;
        width: 100%;
        z-index: 0;
    }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Cleanup Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('cleanup-areas.show', $cleanupArea) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to details
                        </a>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-6">Edit Cleanup Area</h3>

                    <form method="POST" action="{{ route('cleanup-areas.update', $cleanupArea) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $cleanupArea->title) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $cleanupArea->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Severity -->
                        <div class="mb-6">
                            <label for="severity" class="block text-sm font-medium text-gray-700">Severity</label>
                            <select name="severity" id="severity" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                <option value="low" {{ (old('severity', $cleanupArea->severity) == 'low') ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ (old('severity', $cleanupArea->severity) == 'medium') ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ (old('severity', $cleanupArea->severity) == 'high') ? 'selected' : '' }}>High</option>
                            </select>
                            @error('severity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                <option value="reported" {{ (old('status', $cleanupArea->status) == 'reported') ? 'selected' : '' }}>Reported</option>
                                <option value="scheduled" {{ (old('status', $cleanupArea->status) == 'scheduled') ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ (old('status', $cleanupArea->status) == 'completed') ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Map -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <p class="text-sm text-gray-500 mb-2">Click on the map to update the location</p>
                            <div id="edit-map" class="rounded-lg border border-gray-300"></div>
                            
                            <!-- Hidden inputs for coordinates -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $cleanupArea->latitude) }}" required>
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $cleanupArea->longitude) }}" required>
                            
                            <p class="text-sm text-gray-500 mt-2" id="coordinates-display">
                                Coordinates: {{ $cleanupArea->latitude }}, {{ $cleanupArea->longitude }}
                            </p>
                            
                            @error('latitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('longitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Area
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let map;
        let marker;

        function initMap() {
            // Get the cleanup area coordinates
            const location = { 
                lat: parseFloat(document.getElementById('latitude').value), 
                lng: parseFloat(document.getElementById('longitude').value) 
            };

            // Create the map centered at the cleanup area
            map = new google.maps.Map(document.getElementById("edit-map"), {
                zoom: 15,
                center: location,
            });

            // Create marker for the location
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true, // Allow marker to be dragged
                title: "Cleanup location"
            });

            // Update coordinates when marker is dragged
            marker.addListener('dragend', updateCoordinates);

            // Allow clicking on the map to move the marker
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updateCoordinates();
            });
        }

        // Update hidden form fields and coordinates display
        function updateCoordinates() {
            const position = marker.getPosition();
            const lat = position.lat();
            const lng = position.lng();
            
            // Update hidden form fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            // Update display text
            document.getElementById('coordinates-display').textContent = `Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAHBjvzcG26iURd2HMx3Tf38hnE9EHeoA&callback=initMap" async defer></script>
    @endpush
</x-app-layout>