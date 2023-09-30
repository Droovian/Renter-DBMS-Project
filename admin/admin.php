<?php
session_start();

if(isset($_SESSION['error-messages'])){
    $errors = $_SESSION['error-messages'];

    echo '<div class="text-red-600 font-bold text-center p-2 mb-4">';
    foreach ($errors as $error) {
        echo '<p>' . $error . '</p>';
    }
    echo '</div>';
    unset($_SESSION['error-messages']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <title>List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <p class="text-center text-green-600 text-xl font-bold p-2 mb-4">
        <?php 
        if(isset($_SESSION['success-message'])){
            echo $_SESSION['success-message'];
            unset($_SESSION['success-message']);
        }
        ?>
    </p>

    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">

        <!-- Back to Home Button -->
        <a href="../dist/index.php" class="bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:bg-blue-600 absolute top-4 left-4">Back to Home</a>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="../dist/images/fox.jpg" class="w-20" alt="">
                <h2 class="text-2xl font-semibold ml-4">Renter - Property Sale Form</h2>
            </div>
        </div>

        <form action="handlesubmit.php" method="POST" enctype="multipart/form-data">
            <!-- Property Name -->
            <div class="mb-4">
                <label for="property_name" class="block text-gray-600 text-sm font-medium mb-2">Property Name</label>
                <input type="text" id="property_name" name="property_name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Property Type -->
            <div class="mb-4">
                <label for="property_type" class="block text-gray-600 text-sm font-medium mb-2">Property Type</label>
                <select id="property_type" name="property_type" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                    <option value="condo">Condo</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <!-- Rent Amount -->
            <div class="mb-4">
                <label for="rent_amount" class="block text-gray-600 text-sm font-medium mb-2">Monthly Rent (₹)</label>
                <input type="number" id="rent_amount" name="rent_amount" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-600 text-sm font-medium mb-2">Description</label>
                <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" rows="4" required></textarea>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600 text-sm font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Contact Number -->
            <div class="mb-4">
                <label for="contact_number" class="block text-gray-600 text-sm font-medium mb-2">Contact Number</label>
                <input type="tel" id="contact_number" name="contact_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location" class="block text-gray-600 text-sm font-medium mb-2">Location</label>
                <input type="text" id="location" name="location" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-gray-600 text-sm font-medium mb-2">Upload Image</label>
                <input type="file" id="image" name="image" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:bg-amber-600">Submit</button>
            </div>
        </form>
    </div>
</body>

<footer class="flex justify-between mt-10 border-black fixed bottom-0 bg-transparent w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Jobs</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Terms</a>
    </div>
    
</footer>

</html>

<?php

session_destroy();

?>


