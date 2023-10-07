<?php
session_start();
include("../dist/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and validate/sanitize it
    $propertyID = isset($_GET['property_id']) ? $_GET['property_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $checkIn = isset($_POST['check-in']) ? $_POST['check-in'] : '';
    $checkOut = isset($_POST['check-out']) ? $_POST['check-out'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Perform further validation as needed (e.g., check date formats, email format, etc.)
    
    // Insert the booking data into the "bookings" table
    $sql = "INSERT INTO bookings (property_id, name, email, mobile, check_in, check_out, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'not_confirmed')";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssss", $propertyID, $name, $email, $mobile, $checkIn, $checkOut, $message);
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_affected_rows($conn) > 0) {
            // Display a success message and redirect the user back to the booking page
            echo '<script>alert("Booking application has been sent."); window.location.href = "booking.php?property_id=' . $propertyID . '";</script>';
            exit();
        } else {
            echo "Error submitting the booking. Please try again.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect the user back to the booking page if they access this script directly
    header("Location: booking.php?property_id=" . $propertyID);
    exit();
}
?>