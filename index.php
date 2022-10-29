
<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.0/dist/leaflet.css" />

        <link rel="stylesheet" href="dist/leaflet.awesome-markers.css">
        <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">

        <script src="https://unpkg.com/leaflet@1.7.0/dist/leaflet.js"></script>
        <script src="js/leaflet-realtime.js"></script>

        <title>Map - Leaflet</title>
	</head>

	<body>

    <div id="map"></div>

    <script src="dist/leaflet.awesome-markers.js"></script>

    <script>
        var map = L.map('map'),
            realtime = L.realtime({
            url: 'http://127.0.0.1/map/admin/api/v1/getpoint.php',
            crossOrigin: true,
            type: 'json'
        }, {
            interval: 3 * 1000
        }).addTo(map);

        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        realtime.on('update', function() {
            map.fitBounds(realtime.getBounds(), {maxZoom: 14});
        });

        function onMapClick(e) {
            L.popup()
                .setLatLng(e.latlng)
                .setContent('Sus coordenadas son: ' + e.latlng.toString())
                .openOn(map);
        }

        map.on('click', onMapClick);

        function onLocationFound(e) {
            L.marker(e.latlng, {icon: L.AwesomeMarkers.icon({icon: 'cog', prefix: 'fa', markerColor: 'darkblue'}) }).addTo(map);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({setView: true, maxZoom: 16});

    </script>

	</body>
</html>