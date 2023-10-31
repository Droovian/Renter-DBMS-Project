<?php 

session_start();
include("../dist/database.php");

// Get the property ID from the query parameter
$propertyID = isset($_GET['property_id']) ? $_GET['property_id'] : null;

if ($propertyID !== null) {
    // Fetch property details based on the propertyID from the database
    $sql = "SELECT * FROM property_listings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $propertyID);
        mysqli_stmt_execute($stmt);
        $propertyDetails = mysqli_stmt_get_result($stmt);
        
        if ($propertyDetails) {
            $property_data = mysqli_fetch_assoc($propertyDetails);
            // Now, you have the details of the selected property to display on the booking page
        } else {
            echo "Property not found.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "
    <p class='flex justify-between font-body'>Invalid property ID.</p>
    ";
}

// Close the database connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <title>Renter - Booking Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
        /* Sidebar styles */
        .sidebar {
            width: 260px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar li {
            padding: 10px 20px;
            border-left: 3px solid transparent;
        }
        .sidebar li:hover {
            background-color: #F3F4F6;
            border-left-color: #F59E0B;
        }
    </style>

<body class="bg-gray-100">

<div class="sidebar bg-white h-screen fixed top-0 left-0 overflow-y-auto">
        <ul>
            <li class="text-xl font-body hover:text-amber-500">
                <a href="../admin/adminlogin.php">Admin</a>
            </li>
            <li class="text-xl font-body hover:text-amber-500">
                <a href="../dist/index.php">Back to home</a>
            </li>
            <!-- Add other sidebar links here -->
        </ul>
       
    </div>
    <section class="container max-w-md mx-auto mt-8 p-4 bg-white rounded-md shadow-md">
    <h1 class="text-2xl font-semibold text-center mb-6">Book This Property</h1>
    <form action="submit_booking.php?property_id=<?php echo $propertyID; ?>" method="post" id="booking-form">
        <div class="mb-4">
            <label for="name" class="block text-gray-600 font-semibold">Your Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-600 font-semibold">Your Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
        <div class="mb-4">
            <label for="mobile" class="block text-gray-600 font-semibold">Mobile Number</label>
            <input type="tel" id="mobile" name="mobile" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
        <div class="mb-4">
            <label for="check-in" class="block text-gray-600 font-semibold">Check-In Date</label>
            <input type="date" id="check-in" name="check-in" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
        <div class="mb-4">
            <label for="check-out" class="block text-gray-600 font-semibold">Check-Out Date</label>
            <input type="date" id="check-out" name="check-out" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
        <div class="mb-4">
            <label for="message" class="block text-gray-600 font-semibold">Message (optional)</label>
            <textarea id="message" name="message" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" rows="4"></textarea>
        </div>
        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">Go To Payment</button>
    </form>
</section>

<!-- Footer and other content here -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get form element
        const form = document.querySelector('#booking-form');

        // Add an event listener to the form submission
        form.addEventListener('submit', function (event) {
            // Flag to track whether the form is valid
            let isValid = true;

            // Regular expressions for email and 10-digit mobile number
            const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
            const mobilePattern = /^\d{10}$/;

            // Get input elements
            const emailInput = document.querySelector('#email');
            const mobileInput = document.querySelector('#mobile');
            const checkInInput = document.querySelector('#check-in');
            const checkOutInput = document.querySelector('#check-out');

            // Check if the email is valid
            if (!emailPattern.test(emailInput.value)) {
                isValid = false;
                alert('Please enter a valid email address.');
                emailInput.focus();
            }

            // Check if the mobile number is valid
            if (!mobilePattern.test(mobileInput.value)) {
                isValid = false;
                alert('Please enter a 10-digit mobile number.');
                mobileInput.focus();
            }

            // Check if the check-in and check-out dates are in the present
            const today = new Date();
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            if (checkInDate < today) {
                isValid = false;
                alert('Check-In date must be in the present or future.');
                checkInInput.focus();
            }

            if (checkOutDate < today) {
                isValid = false;
                alert('Check-Out date must be in the present or future.');
                checkOutInput.focus();
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>

    <!-- Footer and other content here -->
    
</body>
</html>