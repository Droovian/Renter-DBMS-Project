<!DOCTYPE html>
<html>
<head>
	<title>Geolocation</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
	<style>
		body {
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>
	<div id="map" style="width: 50%; height: 50vh"></div>
	<input type="text" id="locationInput" placeholder="Enter a location">
	<button onclick="geocodeLocation()">Geocode Location</button>
	<div id="latlon">Latitude: N/A, Longitude: N/A</div>
	<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>

	<script>
		var map = L.map('map').setView([15.286691, 73.969780], 10);
		mapLink = "<a href='http://openstreetmap.org'>OpenStreetMap</a>";
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { attribution: 'Leaflet &copy; ' + mapLink + ', contribution', maxZoom: 18 }).addTo(map);

		function geocodeLocation() {
			var locationInput = document.getElementById('locationInput').value;
			fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + locationInput)
				.then(response => response.json())
				.then(data => {
					if (data && data[0]) {
						var lat = parseFloat(data[0].lat);
						var lon = parseFloat(data[0].lon);
						document.getElementById('latlon').textContent = 'Latitude: ' + lat + ', Longitude: ' + lon;

						var newMarker = L.marker([lat, lon]).addTo(map);
						map.setView([lat, lon], 11);
					} else {
						alert('Location not found');
					}
				})
				.catch(error => {
					console.error(error);
				});
		}
	</script>
</body>
</html>