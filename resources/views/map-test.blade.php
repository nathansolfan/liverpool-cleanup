<!DOCTYPE html>
<html>
<head>
    <title>Map Test Page</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        #map {
            height: 500px;
            width: 100%;
            border: 1px solid #000;
        }
        .info {
            margin-bottom: 20px;
            background: #f8f8f8;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="info">
        <h1>Map Test Page</h1>
        <p>This page will test if Leaflet maps work at all on your server.</p>
        <p>If you see a map below, then the issue is with your form integration.</p>
        <p id="status" style="color: green;">JavaScript is running!</p>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        console.log('Script started...');

        // Show JavaScript is working
        document.getElementById('status').innerHTML = 'JavaScript is working! Trying to create map...';

        // Create map
        try {
            const map = L.map('map').setView([53.4084, -2.9916], 12);
            console.log('Map object created successfully');

            // Add tiles
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            console.log('Tiles added successfully');

            // Add a marker
            const marker = L.marker([53.4084, -2.9916]).addTo(map);
            marker.bindPopup("Liverpool, UK").openPopup();

            // Handle clicks
            map.on('click', function(e) {
                console.log('Clicked at: ' + e.latlng);
                alert('You clicked the map at ' + e.latlng);
            });

            // Confirm success
            document.getElementById('status').innerHTML = 'Map created successfully! You should see it below.';
            console.log('Everything loaded successfully!');

        } catch (error) {
            console.error('Error creating map:', error);
            document.getElementById('status').innerHTML = 'Error: ' + error.message;
            document.getElementById('status').style.color = 'red';
        }
    </script>
</body>
</html>
