<x-app-layout>
    @push('styles')
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

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Add New Button -->
                    <div class="mb-6">
                        <a href="{{ route('cleanup-areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Report New Area
                        </a>
                    </div>

                    @if ($cleanupAreas->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-600">No cleanup areas reported yet.</p>
                            <a href="{{ route('cleanup-areas.create') }}" class="mt-2 text-blue-600 hover:text-blue-800">
                                Be the first to report an area!
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Severity
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reported Byy
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cleanupAreas as $area)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $area->title }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($area->severity == 'high') bg-red-100 text-red-800
                                                    @elseif($area->severity == 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst($area->severity) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($area->status == 'completed') bg-green-100 text-green-800
                                                    @elseif($area->status == 'scheduled') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($area->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $area->user->name ?? 'Unknown' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $area->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('cleanup-areas.show', $area) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <a href="{{ route('cleanup-areas.edit', $area) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('cleanup-areas.destroy', $area) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this cleanup area?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    let map;
    const markers = [];

    function initMap() {
        console.log('Initializing Google Map for index page...');

        // Liverpool center coordinates
        const liverpool = { lat: 53.4084, lng: -2.9916 };

        map = new google.maps.Map(document.getElementById("index-map"), {
            zoom: 11,
            center: liverpool,
        });

        // Get cleanup areas data
        const cleanupAreas = @json($cleanupAreas);
        console.log('Cleanup areas data:', cleanupAreas);

        // Add markers for each cleanup area
        cleanupAreas.forEach((area, index) => {
            // Create color-coded pin based on severity
            let pinColor = '4CAF50'; // green for low
            if (area.severity === 'high') pinColor = 'F44336'; // red
            else if (area.severity === 'medium') pinColor = 'FF9800'; // orange

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(area.latitude), lng: parseFloat(area.longitude) },
                map: map,
                title: area.title,
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/' +
                        (pinColor === 'F44336' ? 'red' : pinColor === 'FF9800' ? 'orange' : 'green') + '-dot.png'
                }
            });

            markers.push(marker);

            // Create info window content
            const infoContent = `
                <div style="max-width: 200px;">
                    <h4 style="font-weight: bold; margin-bottom: 4px;">${area.title}</h4>
                    <p style="margin-bottom: 4px;">Severity: <span style="color: #${pinColor};">${area.severity.toUpperCase()}</span></p>
                    <p style="margin-bottom: 4px;">Status: ${area.status}</p>
                    <p style="margin-bottom: 4px;">Reported: ${new Date(area.created_at).toLocaleDateString()}</p>
                    <a href="/cleanup-areas/${area.id}" style="color: #1976D2; text-decoration: underline;">View Details</a>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: infoContent
            });

            marker.addListener('click', function() {
                // Close all other info windows
                markers.forEach(m => {
                    if (m.infoWindow) m.infoWindow.close();
                });

                infoWindow.open(map, marker);
            });

            marker.infoWindow = infoWindow;
        });

        // Fit map to show all markers if there are any
        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(marker => bounds.extend(marker.getPosition()));
            map.fitBounds(bounds);

            // Don't zoom in too close
            const maxZoom = 15;
            if (map.getZoom() > maxZoom) {
                map.setZoom(maxZoom);
            }
        }

        console.log('Google Map initialized successfully!');
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
