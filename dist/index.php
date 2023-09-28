<?php
session_start();
include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="flex flex-row">
    <div class="flex flex-row space-x-3 w-full h-auto p-2">
        <div class="mt-3 text-black p-2 mr-8">
            <h1 class="font-bold font-body text-3xl mx-5">Renter</h1>
        </div>
    </div>
    
    <div class="justify-center  text-amber-700 font-light p-3 mt-5 mr-5">
        <a href="signup.php" class="">Login/Register</a>
    </div>

    
    </div>
</div>

<section class="hero bg-amber-100 text-center py-24 rounded-lg">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold">Find Your Dream Rental</h1>
            <p class="text-xl mt-4">Explore our wide range of rental properties</p>
            <form action="search.php" method="get" class="mt-8 flex items-center justify-center">
                <div class="relative rounded-md shadow-md flex">
                <input type="text" name="location" placeholder="Enter Location" class="bg-white rounded-md p-4 pr-12 w-80 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent flex-grow">
                 <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                  Search
                </button>
                </div>
            </form>

        </div>
    </section>

    <?php
$sql = "SELECT * FROM property_listings";

$get_properties = mysqli_query($conn, $sql);

if (mysqli_num_rows($get_properties) > 0) {
    echo "<main class='mt-14 mx-10'>";
    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6'>";
    
    while ($property_data = mysqli_fetch_assoc($get_properties)) {
        $name = $property_data['property_name'];
        $location = $property_data['location'];
        $description = $property_data["description"];
        $imagepath = $property_data['image_path'];
        $rent_amount = $property_data['rent_amount'];
        
        echo "
        <div class='bg-white rounded-lg shadow-md'>
            <img src='$imagepath' alt='Property Image' class='rounded-t-lg w-full h-64 object-cover'>
            <div class='p-4'>
                <p class='text-xl font-semibold'>$name</p>
                <p class='text-gray-600'>$location</p>
                <p class='text-sm mt-2'>$description</p>
                <p class='text-xl font-bold mt-4'>₹$rent_amount per night</p>
            </div>
        </div>";
    }
    
    echo "</div>";
    echo "</main>";
} else {
    echo "No properties found in the database";
}
?>

   


<section class="additional-content bg-gray-100 py-20">
        <div class="container mx-auto p-5">
            <h2 class="text-2xl font-bold mb-5">Why Choose Renter?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">Variety of Properties</h3>
                    <p class="text-gray-600">Explore a wide range of rental properties, from cozy apartments to luxurious villas.</p>
                </div>
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">User-Friendly Interface</h3>
                    <p class="text-gray-600">Our website is designed to make your property search easy and efficient.</p>
                </div>
                <div class="bg-white p-5 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold">Trusted Listings</h3>
                    <p class="text-gray-600">All listings on Renter are verified to ensure your safety and satisfaction.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="customer-reviews bg-gray-200 py-20 mb-10">
    <div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold mb-5">Customer Reviews</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Review 1 -->
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <!-- Customer Image (Replace 'customer-image.jpg' with the actual image URL) -->
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">

                    <!-- Customer Review Content -->
                    <div>
                        <h3 class="text-lg font-semibold">John Doe</h3>
                        <p class="text-gray-600">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod diam at bibendum."</p>
                    </div>
                </div>
            </div>

            <!-- Review 2 (Repeat structure as needed) -->
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Jane Smith</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>

            <!-- Review 3 (Repeat structure as needed) -->
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Sarah Johnson</h3>
                        <p class="text-gray-600">"Vestibulum vehicula lacus nec nunc hendrerit, ac volutpat tellus laoreet."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Walden</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Emily Anderson</h3>
                        <p class="text-gray-600">"Lorem, ipsum dolor sit amet consectetur adipisicing elit..."</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-5 rounded-md shadow-md">
                <div class="flex items-center space-x-4">
                    <img src="../dist/images/userfinal.svg" alt="Customer Image" class="h-16 w-16 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">Marques Joe</h3>
                        <p class="text-gray-600">"Sed ullamcorper tellus vel finibus. Nunc nec eleifend velit."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ... (footer section remains the same) ... -->
</body>
</html>








<footer class="flex justify-between border-black fixed bottom-0 bg-white w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Jobs</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Terms</a>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <a href="../admin/admin.php" class="text-sm font-light underline text-amber-700 hover:text-amber-800">List</a>
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
        
    </div>
</footer>
</body>
</html>
<script src="fetch.js" defer></script>

<?php
    // echo $_SESSION["email"] . "<br>";
    // echo $_SESSION["password"] . "<br>";

    if(isset($_POST["logout"])){
         session_destroy();
        // header("Location: login.php");
    }
    
?>