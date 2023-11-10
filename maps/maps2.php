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
    $query = "SELECT id, latitude, longitude FROM coordinates";
    $result = $conn->query($query);

    $coordinates = []; // Array to store latitude and longitude pairs

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coordinates[] = [$row["id"], $row["latitude"], $row["longitude"]];
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
            L.marker([<?php echo $coord[1]; ?>, <?php echo $coord[2]; ?>]).addTo(map);
        <?php endforeach; ?>


        <?php foreach ($coordinates as $coord): ?>
            var marker = L.marker([<?php echo $coord[1]; ?>, <?php echo $coord[2]; ?>]).addTo(map);
            <?php  
                include("../dist/database.php");

                $sql = "SELECT property_name, property_type, description, name FROM property_listings WHERE id=" . $coord[0];

                $result = $conn->query($sql);
                $propertyName = "No property found"; // Default value if no property found

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $propertyName = $row['property_name'];
                    $propertyType = $row['property_type'];
                    $sellerName = $row['name'];
                    $description = $row['description'];
                }

                $conn->close();
    ?>
            marker.bindPopup("<b>Location Details</b><br>Name: <?php echo $propertyName; ?><br>Type: <?php echo $propertyType; ?><br>Seller Name: <?php echo $sellerName;  ?><br>Description: <?php echo $description;   ?>");
            marker.on('mouseover', function (e) {
                this.openPopup();
            });
            marker.on('mouseout', function (e) {
                this.closePopup();
            });
            marker.on('click', function() {
                window.location.href = '../bookings/booking.php?property_id=<?php echo $coord[0]; ?>';
            });
        <?php endforeach; ?>

        // Get the user's current location
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;
                console.log(userLatitude);
                console.log(userLongitude);
                var userMarker = L.marker([userLatitude, userLongitude], { icon: L.Icon.Default }).addTo(map);
                userMarker.bindPopup("<b>Your Current Location</b>");
                userMarker.on('mouseover', function (e) {
                    this.openPopup();
                });
                userMarker.on('mouseout', function (e) {
                    this.closePopup();
                });
            }, function(error) {
                console.error("Error getting the user's location:", error);
                L.marker([0, 0]).addTo(map).bindPopup("Location access denied or unavailable.");
            });
        
    </script>

</body>
</html>
