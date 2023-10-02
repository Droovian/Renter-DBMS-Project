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
<body class="font-body">
 
    <div class="rounded-md border-2 w-1/2 border-gray-400 p-2 mx-auto mt-48">
    <h1 class="text-red-500 text-xl font-bold text-left">Reset Password</h1>
    <hr>
    <h2 class="">Email Address</h2>
        <form action="resetcode.php" class="flex flex-col justify-center items-center space-y-4 " method="post">
            <input type="email" name="email" class="border-2 border-black w-1/2 p-2 rounded-md" placeholder="Enter Email Address" required autocomplete="off">
            <button name="passreset" type="submit" class="bg-sky-600 text-white px-3 py-2 rounded-md hover:bg-sky-400 w-auto mx-auto">Send Password Reset Link</button>
        </form>
    </div>
    
</body>
</html>

