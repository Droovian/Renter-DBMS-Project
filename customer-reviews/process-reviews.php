<?php
include("../dist/database.php");
session_start();

$email = $_SESSION['check'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST["booking_id"];

    try {
        // Check if the user has already reviewed this property
        $email = $_SESSION['check'];
        $userSql = "SELECT id FROM finalusers WHERE email = ?";
        $stmtUser = mysqli_prepare($conn, $userSql);
        mysqli_stmt_bind_param($stmtUser, "s", $email);
        mysqli_stmt_execute($stmtUser);
        mysqli_stmt_bind_result($stmtUser, $userID);
        mysqli_stmt_fetch($stmtUser);
        mysqli_stmt_close($stmtUser);

        if ($userID) {
            // Check if the user has already reviewed this property
            $sqlCheckReview = "SELECT COUNT(*) FROM reviews WHERE property_id = ? AND user_id = ?";
            $stmtCheckReview = mysqli_prepare($conn, $sqlCheckReview);
            mysqli_stmt_bind_param($stmtCheckReview, "ii", $bookingID, $userID);
            mysqli_stmt_execute($stmtCheckReview);
            mysqli_stmt_bind_result($stmtCheckReview, $reviewCount);
            mysqli_stmt_fetch($stmtCheckReview);
            mysqli_stmt_close($stmtCheckReview);

            if ($reviewCount == 0) {
                // The user has not reviewed this property
                $sql = "SELECT property_id, id FROM bookings WHERE id = $bookingID AND status = 'confirmed'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // The booking is valid and confirmed, proceed to insert the review
                    $rating = $_POST["rating"];
                    $description = mysqli_real_escape_string($conn, $_POST["description"]);

                    // Get property ID from the query result
                    $row = mysqli_fetch_assoc($result);
                    $propertyID = $row['property_id'];

                    // Insert the review into the reviews table
                    $insertSql = "INSERT INTO reviews (property_id, user_id, rating, description) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insertSql);

                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "iiis", $propertyID, $userID, $rating, $description);

                        if (mysqli_stmt_execute($stmt)) {
                            // Review inserted successfully
                            echo "<script>alert('Review inserted successfully.'); window.location.href = 'reviews.php';</script>";
                        } else {
                            // Error inserting review
                            echo "<script>alert('Failed to insert the review.'); window.location.href = 'reviews.php';</script>";
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<script>alert('Failed to prepare the review insertion.'); window.location.href = 'reviews.php';</script>";
                    }
                } else {
                    // Invalid booking ID
                    echo "<script>alert('Invalid booking ID.'); window.location.href = 'reviews.php';</script>";
                }
            } else {
                // User has already reviewed this property
                echo "<script>alert('You have already reviewed this property.'); window.location.href = 'reviews.php';</script>";
            }
        } else {
            // User not found in finalusers table
            echo "<script>alert('User not found in finalusers table.'); window.location.href = 'reviews.php';</script>";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            // MySQL error code 1062 indicates a duplicate entry error
            echo "<script>alert('You have already reviewed this property.'); window.location.href = 'reviews.php';</script>";
        } else {
            // Other database error, handle as needed
            echo "<script>alert('Failed to insert the review.'); window.location.href = 'reviews.php';</script>";
        }
    }
}
?>
