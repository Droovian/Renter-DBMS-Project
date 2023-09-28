<?php
session_start();

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
                <div class="relative rounded-md shadow-md">
                    <input type="text" name="location" placeholder="Enter Location" class="bg-white rounded-md p-4 pr-12 w-80 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <button type="submit" class="absolute right-3 top-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

<main class="mt-14 mx-10">
<div class="grid md:grid-rows-4 md:grid-cols-4 md:gap-3 sm:grid sm:grid-rows-5 sm:grid-cols-2 sm:items-center md:items-center lg:items-center">
    <div class="flex flex-col h-96 w-72">
        <img src="images/download.jpeg" class="rounded-xl" alt="img1">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Whispering Pines</p>
            <i class="fa-solid fa-star"></i>
            <p class="text-sm font-light">4.0</p>
        </div>
        <p class="text-sm font-light">Jibhi, India</p>
        <p class="text-sm font-light">62 kilometres away</p>
        <p class="text-sm font-light">17 Aug - 21 Aug</p>
        <p><span class="font-bold">₹11500</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/img2.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">The Vintage</p>
            <p class="text-sm font-light">4.0</p>
        </div>
        <p class="text-sm font-light">Srinagar, India</p>
        <p class="font-light text-sm">86 kilometres away</p>
        <p class="font-light text-sm">20 Aug - 23 Aug</p>
        <p><span class="font-bold">₹28000</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/img3.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="font-bold text-sm">JW Marriott</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Goa, India</p>
        <p class="font-light text-sm">30 kilometres away</p>
        <p class="font-light text-sm">25 Aug - 27 Aug</p>
        <p><span class="font-bold">₹60000</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/alila.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Alila Diwa Goa</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Goa, India</p>
        <p class="font-light text-sm">20 kilometres away</p>
        <p class="font-light text-sm">15 Aug - 16 Aug</p>
        <p><span class="font-bold">₹48000</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/maldive.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">The Intercontinental</p>
            <p class="text-sm font-light">4.0</p>
        </div>
        <p class="text-sm font-light">Maldives</p>
        <p class="font-light text-sm">132 kilometres away</p>
        <p class="font-light text-sm">1 Sep - 3 Sep</p>
        <p><span class="font-bold">₹70000</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/himalayan.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Himalayan Cedar</p>
            <p class="text-sm font-light">2.5</p>
        </div>
        <p class="text-sm font-light">Himachal Pradesh</p>
        <p class="font-light text-sm">231 kilometres away</p>
        <p class="font-light text-sm">12 Sep - 14 Sep</p>
        <p><span class="font-bold">₹9500</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/udaipur.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Radisson Blu Palace</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Udaipur, Rajasthan</p>
        <p class="font-light text-sm">50 kilometres away</p>
        <p class="font-light text-sm">12 Sep - 14 Sep</p>
        <p><span class="font-bold">₹29500</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/lalit.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">The LaLit</p>
            <p class="text-sm font-light">4.0</p>
        </div>
        <p class="text-sm font-light">Mumbai, India</p>
        <p class="font-light text-sm">15 kilometres away</p>
        <p class="font-light text-sm">21 Sep - 24 Sep</p>
        <p><span class="font-bold">₹37500</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/lemeridien.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Le Meridien</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Hyderabad, India</p>
        <p class="font-light text-sm">70 kilometres away</p>
        <p class="font-light text-sm">20 Sep - 22 Sep</p>
        <p><span class="font-bold">₹17500</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/leela.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">The Leela Palace</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Bengaluru, Karnataka</p>
        <p class="font-light text-sm">80 kilometres away</p>
        <p class="font-light text-sm">5 Oct - 8 Oct</p>
        <p><span class="font-bold">₹97500</span> night</p>
    </div>
    
</div>

</main>
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