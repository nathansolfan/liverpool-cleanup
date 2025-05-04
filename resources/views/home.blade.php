<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liverpool Cleanup Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Clean Liverpool Together</h1>
                    <p class="mt-2 text-gray-600">Join our community effort to make Liverpool cleaner and greener</p>
                    <div class="mt-6">
                        <a href="{{ route('cleanup-areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Report an Area
                        </a>
                        <a href="{{ route('cleanup-areas.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View All Areas
                        </a>
                        <a href="#" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Volunteer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cleanup Map</h2>

                    <!-- Map Filters -->
                    <div class="mb-4">
                        <select id="status-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2">
                            <option value="">All Statuses</option>
                            <option value="reported">Reported</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                        </select>

                        <select id="severity-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Severities</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <!-- Map Container -->
                    <div id="cleanup-map" class="h-96 w-full rounded-lg border border-gray-300 bg-gray-100 flex items-center justify-center">
                        <p class="text-gray-500">Map loading...</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['areas_count'] }}</h3>
                        <p class="text-gray-600">Areas Reported</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['completed_count'] }}</h3>
                        <p class="text-gray-600">Areas Cleaned</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['users_count'] }}</h3>
                        <p class="text-gray-600">Volunteers</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Events</h2>

                    <p class="text-gray-600">No upcoming events scheduled. Check back soon!</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
<script>
let map;
let markers = [];

function initMap() {
    // Center on Liverpool
    const liverpool = { lat: 53.4084, lng: -2.9916 };

    map = new google.maps.Map(document.getElementById("cleanup-map"), {
        zoom: 11,
        center: liverpool,
        styles: [
            // Optional: Add a lighter map style for the overview
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [{"saturation": -30}]
            }
        ]
    });

    // Load initial cleanup areas
    loadCleanupAreas();

    // Add filter listeners
    document.getElementById('status-filter').addEventListener('change', loadCleanupAreas);
    document.getElementById('severity-filter').addEventListener('change', loadCleanupAreas);
}

function loadCleanupAreas() {
    const statusFilter = document.getElementById('status-filter').value;
    const severityFilter = document.getElementById('severity-filter').value;

    // Clear existing markers
    markers.forEach(marker => marker.setMap(null));
    markers = [];

    // Fetch filtered data (you'll need to create this API endpoint)
    fetch(`/api/cleanup-areas?status=${statusFilter}&severity=${severityFilter}`)
        .then(response => response.json())
        .then(areas => {
            areas.forEach(area => {
                const markerColor = getMarkerColor(area.severity);

                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(area.latitude), lng: parseFloat(area.longitude) },
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: markerColor,
                        fillOpacity: 0.8,
                        strokeColor: markerColor,
                        strokeWeight: 1
                    }
                });

                // Simple info window
                const infoWindow = new google.maps.InfoWindow({
                    content: `<div style="padding: 10px;">
                                <strong>${area.title}</strong><br>
                                Severity: ${area.severity}<br>
                                <a href="/cleanup-areas/${area.id}" style="color: blue;">View Details</a>
                              </div>`
                });

                marker.addListener('click', () => infoWindow.open(map, marker));
                markers.push(marker);
            });
        });
}

function getMarkerColor(severity) {
    switch(severity) {
        case 'high': return '#F44336';
        case 'medium': return '#FF9800';
        default: return '#4CAF50';
    }
}

window.onload = function() {
    if (typeof google === 'undefined') {
        console.error('Google Maps failed to load!');
        document.getElementById('cleanup-map').innerHTML = '<p class="text-red-500">Error loading map</p>';
    }
};
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAHBjvzcG26iURd2HMx3Tf38hnE9EHeoA&callback=initMap" async defer></script>
@endpush
</x-app-layout>
