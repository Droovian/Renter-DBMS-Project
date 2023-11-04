<!DOCTYPE html>
<html>
<head>
    <title>Display City Name and Map</title>
    <!-- Include Leaflet.js library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
      /* Set the map container's size */
      #map {
        height: 400px;
        width: 100%;
      }
    </style>
</head>
<body>
    <?php
    // Step 1: Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "RENTERUSERS";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Retrieve latitude and longitude from the database
    $query = "SELECT latitude, longitude FROM coordinates";
    $result = $conn->query($query);

    $coordinates = []; // Array to store latitude and longitude pairs

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coordinates[] = [$row["latitude"], $row["longitude"]];
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "No results found in the database.";
    }
    ?>

    <!-- Create a map container -->
    <div id="map"></div>

    <script>
        // Create a map
        var map = L.map("map").setView([15.5186, 73.8274], 12);

        // Add a tile layer to the map (you can use different map tile providers)
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        // Loop through the coordinates array and create markers for each pair
        <?php foreach ($coordinates as $coord): ?>
            L.marker([<?php echo $coord[0]; ?>, <?php echo $coord[1]; ?>]).addTo(map);
        <?php endforeach; ?>

        // Get the user's current location
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;
                console.log(userLatitude);
                console.log(userLongitude);
                // Add a marker for the user's current location with the custom icon
                L.marker([userLatitude, userLongitude], { icon: L.Icon.Default }).addTo(map);
            });
        } else {
            console.log("Geolocation is not available in this browser.");
        }
    </script>

</body>
</html>
