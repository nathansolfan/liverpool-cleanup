<x-app-layout>
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <style>
    #index-map {
        height: 400px;
        width: 100%;
        z-index: 0;
    }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cleanup Areas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Map Container -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Map Overview</h3>
                    <div id="index-map" class="border border-gray-300 rounded-md"></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Rest of your existing code remains the same -->
                    <!-- Add New Button -->
                    <div class="mb-6">
                        <a href="{{ route('cleanup-areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Report New Area
                        </a>
                    </div>

                    <!-- ... rest of your existing code ... -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map centered on Liverpool
        const map = L.map('index-map').setView([53.4084, -2.9916], 11);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add markers for each cleanup area
        const cleanupAreas = @json($cleanupAreas);

        cleanupAreas.forEach(area => {
            // Create color-coded markers based on severity
            let color = 'green'; // default for low severity
            if (area.severity === 'high') color = 'red';
            else if (area.severity === 'medium') color = 'orange';

            const marker = L.circleMarker([area.latitude, area.longitude], {
                color: color,
                radius: 8,
                fillOpacity: 0.8
            }).addTo(map);

            // Add popup with area information
            marker.bindPopup(`
                <div style="min-width: 200px;">
                    <h4 style="font-weight: bold; margin-bottom: 4px;">${area.title}</h4>
                    <p style="margin-bottom: 4px;">Severity: <span style="color: ${color};">${area.severity.toUpperCase()}</span></p>
                    <p style="margin-bottom: 4px;">Status: ${area.status}</p>
                    <a href="/cleanup-areas/${area.id}" style="color: blue; text-decoration: underline;">View Details</a>
                </div>
            `);
        });

        // Fit map to show all markers
        if (cleanupAreas.length > 0) {
            const group = new L.featureGroup(Array.from(document.querySelectorAll('.leaflet-marker-icon')));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    });
    </script>
    @endpush
</x-app-layout>
