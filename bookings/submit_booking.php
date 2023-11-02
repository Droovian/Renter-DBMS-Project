<?php
session_start();
include("../dist/database.php");

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["submission"]))) {
    // Retrieve form data and validate/sanitize it
    $propertyID = isset($_GET['property_id']) ? $_GET['property_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $checkIn = isset($_POST['check-in']) ? $_POST['check-in'] : '';
    $checkOut = isset($_POST['check-out']) ? $_POST['check-out'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Perform further validation as needed (e.g., check date formats, email format, etc.)

    // Check for date availability
    $dateAvailable = true;

    // Check if the selected dates overlap with existing bookings
    $sql = "SELECT * FROM bookings WHERE property_id = ? AND (
        (check_in <= ? AND check_out >= ?)
        OR (check_in <= ? AND check_out >= ?)
        OR (check_in >= ? AND check_out <= ?)
    )";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssss", $propertyID, $checkIn, $checkOut, $checkIn, $checkOut, $checkIn, $checkOut);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $dateAvailable = false;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // If the selected dates are not available, display an error message
    if (!$dateAvailable) {
        echo '<script>alert("Selected Dates are not available. Please choose different dates."); window.location.href = "booking.php?property_id=' . $propertyID .  '&property_name=' . $_SESSION['propsname'] .' ";</script>';
        exit();
    }

    // Insert the booking data into the "bookings" table
    $sql = "INSERT INTO bookings (property_id, name, email, mobile, check_in, check_out, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'not_confirmed')";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssss", $propertyID, $name, $email, $mobile, $checkIn, $checkOut, $message);
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['bookingname'] = $name;
            $_SESSION['bookingemail'] = $email;
            $_SESSION['bookingmobile'] = $mobile;
            $_SESSION['check-in'] = $_POST['check-in'];
            // Get the customer ID for the last inserted booking
            $customerID = mysqli_insert_id($conn);

            // Display a success message with the customer ID and redirect the user back to the booking page
            echo '<script>alert("Booking application has been sent.\nCustomer ID is: ' . $customerID . '\nPlease remember it.\nYou will be now redirected to Payments!"); window.location.href = "payscript.php";</script>';
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
    header("Location: booking.php?property_id=" . $propertyID . "&property_name=" . $propertyName);
    exit();
}
?>
