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
    <title>Verification</title>
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="p-2 m-0 w-full">
       <div class="container flex flex-row items-center space-x-4">
        <a href="signup.php" class="font-body p-2 ml-4 text-2xl font-semibold invisible sm:visible">Renter</a>
</div>
    <p class="text-red-500 text-xl font-light text-center"><?php echo $_SESSION['otpfail'];  ?></p>
    <div class="flex justify-center text-center p-3 border-2 border-amber-700 shadow-md">
        <p class="text-amber-500 text-xl font-body p-2">
        <?php 
        if(isset($_POST['signup'])){
        echo "Email for OTP verification sent to " . $_POST['email'];  
        }
        ?>
     </p>
    </div>
    <div class="mt-16 flex justify-center items-center mx-auto border-2 border-black p-2 w-1/2 bg-white h-96 ">
        <form action="query.php" class="flex flex-col mx-auto space-y-4 h-auto p-7" method="post">
            <div class="flex flex-row space-x-4">
                <h2 class="mx-auto font-body text-3xl mr-10 my-auto text-amber-600">Enter the otp</h2>
                <img src="images/fox.jpg" alt="fox-img" class="w-16">
            </div>
            <input type="number" name="otpverify" autocomplete="off" required class="border-2 border-black w-96 mx-auto p-2 mb-4">
            <input type="submit" name="authenticate" value="Authenticate" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50 w-1/2 mx-auto">
        </form>
    </div>
</body>
</html>

<?php

$email_id =  $_POST["email"];
$sql = "SELECT * FROM finalusers WHERE Email = '$email_id'";
$msg = 'An Account exists with the entered email, try logging in';
$search = mysqli_query($conn, $sql);
$search_res = mysqli_fetch_assoc($search);

$check_dup = $search_res["Email"];


$otp = rand(100000, 999999);
    if(isset($_POST["signup"])){

        $_SESSION['otp'] = $otp;
        if($email_id == $check_dup){
            header("Location: signup.php");
            $_SESSION["duplicate"] = 1;
        }
        else {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rentercorp@gmail.com';
        $mail->Password = 'pmcofgzhhtnqscxf';
        // $mail->Password = 'qpfzmpkljjrmlvny';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('rentercorp@gmail.com');
        $mail->addAddress($email_id);
        $mail->isHTML(true);
        $mail->Subject = "OTP(One Time Password)";
        $mail->Body = "Your OTP: " . $otp;
        }
        if(!$mail->send()){
            echo "Error occured";
        }
else{
            $_SESSION['name'] = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $_SESSION['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $pass = $_POST["password"];
            $_SESSION['phone_no'] = $_POST['phoneno'];
            $_SESSION['hash'] = password_hash($pass, PASSWORD_DEFAULT);
            
    }

    }




?>