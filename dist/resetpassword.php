<?php
session_start();
include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="output.css">
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
</head>
<body class="bg-gray-100 font-body">
 
    <div class="bg-white rounded border-2 w-1/2  p-2 mx-auto mt-48">
    <div class="flex justify-between">
        <h1 class="text-amber-700 my-auto text-2xl font-bold text-left">Reset Password</h1>
        <img src="./images/fox.jpg" alt="fox" class="w-16">
    </div>
    <hr>
    <h2 class="font-light mt-2">Email Address</h2>
        <form action="resetcode.php" class="flex flex-col justify-center items-center space-y-7" method="post">
            <input type="email" name="email" class="border-2 border-black w-1/2 p-2 rounded-md" placeholder="Enter Email Address" required autocomplete="off">
            <button name="passreset" type="submit" class="bg-amber-500 text-white px-3 py-2 rounded-md hover:bg-amber-400 w-auto mx-auto">Send Password Reset Link</button>
        </form>
    </div>
    
</body>
</html>

