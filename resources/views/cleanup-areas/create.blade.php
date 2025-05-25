<x-app-layout>
    @push('styles')
    <!-- Remove Leaflet CSS, add Google Maps styles -->
    <style>
    #map {
        height: 256px; /* Override Tailwind h-64 */
        width: 100%;
        z-index: 0; /* Ensure proper stacking */
    }
    </style>
    @endpush

    {{-- Page Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Cleanup Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Display validation errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border-l-4 border-red-500 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM  --}}
                    <form action="{{ route('cleanup-areas.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                        </div>

                        {{-- SEVERITY INPUT --}}
                        <div class="mb-4">
                            <label for="severity" class="block text-sm font-medium text-gray-700">Severity</label>
                            <select name="severity" id="severity"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                                <option value="">Select Severity</option>
                                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                         <!-- Hidden status field with default value of 'reported' -->
                        <input type="hidden" name="status" value="reported">

                        {{-- LOCATION PICKER with Google Maps --}}
                        <div class="mb-6">
                            <p class="block text-sm font-medium text-gray-700 mb-2">Location</p>

                            <!-- Google Maps Container -->
                            <div id="map" style="height: 300px; width: 100%;" class="border border-gray-300 rounded-md mb-2"></div>
                            <p class="text-sm text-gray-500 mb-2">Click on the map to set the location</p>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                        required readonly>
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                        required readonly>
                                </div>
                            </div>
                        </div>

                        {{-- FORM BUTTONS --}}
                        <div class="flex items-center justify-end">
                            <a href="{{ route('cleanup-areas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Report Area
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

    // Start MAP
    function initMap() {
        console.log('Initializing Google Map...');

        // Liverpool center coordinates
        const liverpool = { lat: 53.4084, lng: -2.9916 };

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: liverpool,
        });

        // Add click listener to the map
        map.addListener("click", function(e) {
            placeMarker(e.latLng);
        });

        // Check for existing coordinates (e.g., from validation error)
        const lat = document.getElementById("latitude").value;
        const lng = document.getElementById("longitude").value;
        if (lat && lng) {
            const position = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
            placeMarker(position);
        }

        console.log('Google Map initialized successfully!');
    }

    // Place or move the marker and update form fields
    function placeMarker(location) {
        // Remove existing marker if any
        if (marker) {
            marker.setMap(null);
        }

        // Create new marker
        marker = new google.maps.Marker({
            position: location,
            map: map
        });

        // Update form fields
        document.getElementById("latitude").value = location.lat();
        document.getElementById("longitude").value = location.lng();
    }

    // Wait for DOM to be loaded
    window.onload = function() {
        if (typeof google === 'undefined') {
            console.error('Google Maps failed to load!');
        }
    };
    </script>

    <!-- Load the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAHBjvzcG26iURd2HMx3Tf38hnE9EHeoA&callback=initMap" async defer></script>
    @endpush
</x-app-layout>
