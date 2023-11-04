<?php
session_start();
include("../dist/database.php");

try {
    // Check if lat and lon are set
    if (isset($_POST['lat']) && isset($_POST['lon'])) {
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];
        $id = $_SESSION["property_id_of_user"];

        // Prepare the SQL statement
        $sql = "INSERT INTO coordinates (latitude, longitude, id) VALUES ($lat, $lon, $id)";
        $result = mysqli_query($conn, $sql);

        if($result){
        echo "Coordinates saved successfully!";
        }else{
            echo "No";
        }
    } else {
        echo "Latitude and Longitude not set.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
