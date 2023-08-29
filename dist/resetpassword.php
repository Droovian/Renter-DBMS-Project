<?php
session_start();
include("database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="output.css">
</head>
<body>
    <div class="m-5 p-2 w-1/2 flex justify-center items-center">
        <h2 class="text-red-700">Forgot Password Recovery</h2>
    </div>
    <div>
        <form action="resetpassword.php" class="flex flex-col space-y-2 w-1/2" method="post">
            <label for="" class="text-center">Enter your Email Address</label>
            <input type="email" class="border-2 border-black w-1/2 mx-auto p-2">
        </form>
    </div>
</body>
</html>

<?php



?>