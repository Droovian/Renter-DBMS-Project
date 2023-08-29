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
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-white">
    <div class="flex flex-row">
    <div class="flex flex-row space-x-3 w-full h-auto p-2">
        <div class="">
        <img src="images/fox-svgrepo-com.svg" class="w-14 m-3 hover:animate-bounce" alt="renter-logo" >
        </div>
        <div class="mx-auto inline-block ml-auto mt-3 text-amber-700">
            <h1 class="font-bold tracking-normal font-sans text-3xl mt-2">Renter</h1>
        </div>
    </div>
    <div class="flex flex-row space-x-3 items-center mt-1 p-2 mr-5">

    <form class="md:w-72">   
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border rounded-2xl dark:bg-gray-700 dark:border-black-600 dark:placeholder-gray-400 dark:text-white dark:focus:outline-none" placeholder="Search Properties" autocomplete="off">
        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-amber-700 hover:bg-amber-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">Search</button>
    </div>
    <button type="button" class="border-2 border-black" id="fetch-btn">Location</button>
    </form>
</div>
</div>
<hr class="">

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
    <div class="flex flex-col h-96 w-72">
        <img src="images/hilton.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Hilton</p>
            <p class="text-sm font-light">5.0</p>
        </div>
        <p class="text-sm font-light">Goa, India</p>
        <p class="font-light text-sm">7 kilometres away</p>
        <p class="font-light text-sm">5 Sep - 7 Sep</p>
        <p><span class="font-bold">₹15000</span> night</p>
    </div>
    <div class="flex flex-col h-96 w-72">
        <img src="images/munnar.jpeg" class="rounded-xl h-48" alt="img2">
        <div class="flex justify-between mt-2">
            <p class="text-sm font-bold">Blanket Hotel</p>
            <p class="text-sm font-light">4.5</p>
        </div>
        <p class="text-sm font-light">Munnar, Kerela</p>
        <p class="font-light text-sm">320 kilometres away</p>
        <p class="font-light text-sm">2 Oct - 5 Oct</p>
        <p><span class="font-bold">₹30500</span> night</p>
    </div>
</div>
</main>
    

<footer class="flex justify-between border-black fixed bottom-0 bg-white w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Jobs</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Terms</a>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
        <p class="text-sm">English</p>
        <p class="text-sm">₹ (INR)</p>
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