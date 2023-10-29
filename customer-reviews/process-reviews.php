<?php
include("../dist/database.php");
session_start();

$email = $_SESSION['check'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST["booking_id"];

    try {
        $sql = "SELECT property_id, id FROM bookings WHERE id = $bookingID AND status = 'confirmed'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // The booking is valid and confirmed, proceed to insert the review
            $rating = $_POST["rating"];
            $description = mysqli_real_escape_string($conn, $_POST["description"]);

            $insertSql = "INSERT INTO reviews (property_id, user_id, rating, description) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "iiis", $propertyID, $userID, $rating, $description);

                // Get property ID and user ID from the query result
                $row = mysqli_fetch_assoc($result);
                $propertyID = $row['property_id'];
                $userID = $_SESSION['user_id'];

                if (mysqli_stmt_execute($stmt)) {
                    // Review inserted successfully
                    echo "<script>alert('Review inserted successfully.');
                    window.location.href = 'reviews.php';
                    </script>";
                } else {
                    // Error inserting review
                    echo "<script>
                    alert('Failed to insert the review.');
                    window.location.href = 'reviews.php';
                    </script>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<script>
                alert('Failed to prepare the review insertion.');
                window.location.href = 'reviews.php';
                </script>";
            }
        } else {
            // Invalid booking ID
            echo "
            <script>
            alert('Invalid booking ID.');
            window.location.href = 'reviews.php';
            </script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
