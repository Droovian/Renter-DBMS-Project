<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <title>Renter - Reviews</title>
    <!-- Include Tailwind CSS -->
    <link rel="stylesheet" href="../dist/output.css">
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
</head>
<body class="bg-gray-100">

<div class="sidebar bg-white h-screen fixed top-0 left-0 overflow-y-auto">
    <ul class="pt-0 pl-0"> <!-- Remove padding for the UL element -->
        <li class="text-xl font-body hover:text-amber-500">
            <a href="../admin/adminlogin.php">Admin</a>
        </li>
        <li class="text-xl font-body hover:text-amber-500">
            <a href="../dist/index.php">Back to home</a>
        </li>
        <!-- Add other sidebar links here -->
    </ul>
</div>

<section class="container max-w-md mx-auto mt-8 p-4 bg-white rounded-md shadow-md h-screen flex justify-center items-center">
    <div class="w-full max-w-md"> 
        <div class="flex justify-between">
             <h1 class="text-2xl font-semibold text-center mt-3 mb-6">Write a Review</h1>
             <img src="../dist/images/fox.jpg" alt="fox-image" class="w-16">
        </div>
        <form action="process-reviews.php" method="post">

        <div class="mb-4">
            <label for="booking_id" class="block text-gray-600 font-semibold">Booking ID</label>
            <input type="text" id="booking_id" name="booking_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
        </div>
            <label for="rating" class="block text-gray-600 font-semibold">Rating</label>
            <select id="rating" name="rating" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <div class="mb-4">
                <label for="description" class="block text-gray-600 font-semibold">Review Description</label>
                <textarea id="description" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" rows="4" required></textarea>
            </div>
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50 w-full">Submit Review</button>
        </form>
    </div>
</section>

<!-- Footer and other content here -->

</body>
</html>
