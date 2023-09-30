<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["location"])) {
        $search_location = $_GET["location"];

        // Modify your SQL query to filter properties by location
        $sql = "SELECT * FROM property_listings WHERE location LIKE ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Add a wildcard (%) to the search location to match partially
            $search_location = '%' . $search_location . '%';

            $stmt->bind_param("s", $search_location);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $search_results = []; // Store search results in an array

                while ($property_data = $result->fetch_assoc()) {
                    $search_results[] = $property_data; // Add each result to the array
                }

                $_SESSION['search_results'] = $search_results; // Store the results in a session variable

                $stmt->close();
            } else {
                echo "No properties found for the location: $search_location";
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
header("Location: index.php?search_results=1"); // Redirect back to index.php with search_results parameter
?>
