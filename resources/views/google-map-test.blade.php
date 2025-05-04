<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Test Page</title>
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
        <h1>Google Maps Test Page</h1>
        <p>This page will test if Google Maps work with your API key.</p>
        <p id="status" style="color: green;">JavaScript is running!</p>
    </div>

    <div id="map"></div>

    <script>
        let map;

        function initMap() {
            console.log('Google Maps initMap called');
            document.getElementById('status').innerHTML = 'initMap called! Creating map...';

            try {
                const liverpool = { lat: 53.4084, lng: -2.9916 };

                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: liverpool,
                });

                // Add a marker
                const marker = new google.maps.Marker({
                    position: liverpool,
                    map: map,
                    title: "Liverpool, UK"
                });

                // Add click handler
                map.addListener("click", function(e) {
                    console.log('Clicked at:', e.latLng.toString());
                    alert('You clicked at: ' + e.latLng.toString());
                });

                document.getElementById('status').innerHTML = 'Google Maps loaded successfully!';
                console.log('Google Maps initialized successfully');

            } catch (error) {
                console.error('Error creating map:', error);
                document.getElementById('status').innerHTML = 'Error: ' + error.message;
                document.getElementById('status').style.color = 'red';
            }
        }

        window.onload = function() {
            console.log('Window loaded');
            if (typeof google === 'undefined') {
                document.getElementById('status').innerHTML = 'Google Maps API failed to load!';
                document.getElementById('status').style.color = 'red';
            }
        };
    </script>

    <!-- Load the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAHBjvzcG26iURd2HMx3Tf38hnE9EHeoA&callback=initMap" async defer></script>
</body>
</html>
