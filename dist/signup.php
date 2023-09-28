<?php
    include("database.php");
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-body bg-amber-500 sm:bg-gradient-to-t from-orange-400 to-sky-400">
<p class="text-red-500 text-xl font-light text-center"><?php echo $_SESSION["duplicate"]; ?></p>
<div class="flex items-center justify-center min-h-screen">
        <div class="bg-white flex flex-row w-1/2 shadow-2xl rounded-md border-black sm:text-left">
            <div class="h-auto w-1/2 rounded-md flex flex-col">
                <div class="flex flex-row space-x-2 mt-3 justify-center">
                    <img src="images/userfinal.svg" class="w-7" alt="user-logo">
                    <h2 class="font-bold text-xl">Sign Up</h2>
                </div>
                <span class="font-light p-2 text-sm mb-5 mx-auto">Please enter your details</span>
                <div class="flex flex-col space-y-3 mt-2 p-2">
                    <form action="submitotp.php" class="flex flex-col space-y-3" method="post">
                    <label for="" class="">Name</label>
                    <input type="name" class="p-1 w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter your name" name="name" autocomplete="off" required>
                    <label for="" class="">Email</label>
                    <input type="email" class="p-1 w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Email" name="email" autocomplete="off" required>
                    <label for="" class="">Password</label>
                    <input type="password" class="p-1 w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Password" name="password" autocomplete="off" required>
                    <input type="hidden" name="otp">
                    <div class="flex justify-between items-center p-2">
                        <div class="mr-24 mt-2 flex space-x-2">
                            <input type="checkbox" name="cb" id="cb">
                            <label for="" class="text-xs font-light">Remember Me</label>
                        </div>
                        <a href="login.php" class="text-xs mt-2 font-light mx-auto">Already have an account?</a>
                    </div>
                    <input type="submit" name="signup" value="Register" class=" bg-black text-white text-center rounded-lg hover:bg-white hover:text-black  mx-auto w-32 md:w-1/2 p-2">
                </form>
                </div>
</div>


<img src="images/boat.jpg" alt="boat-image" class="invisible md:visible w-1/2 rounded-md">


</div>

<footer class="flex justify-between border-black fixed bottom-0 bg-transparent w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm  hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm  hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm  hover:underline-offset-1  underline">Jobs</a>
        <a href="#" class="text-sm  hover:underline-offset-1  underline">Terms</a>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
        <p class="text-sm">English</p>
        <p class="text-sm">₹ (INR)</p>
    </div>
</footer>

</body>
</html>

<?php

session_destroy();

?>