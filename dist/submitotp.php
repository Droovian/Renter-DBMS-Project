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
    <link rel="stylesheet" href="output.css">
</head>
<body>

<div class="p-2 m-0 w-full">
       <div class="container flex flex-row items-center space-x-4">
        <a href="signup.php" class="font-body p-2 ml-4 text-2xl font-semibold invisible sm:visible">Renter</a>
</div>
    <p class="text-red-500 text-xl font-light text-center"><?php echo $_SESSION['otpfail'];  ?></p>
    <div class="flex flex-row mx-auto border-2 border-black p-2 w-96 h-auto mt-48">
        <form action="query.php" class="flex flex-col justify-center mx-auto space-y-4" method="post">
            <h2 class="mx-auto font-light text-lg">Enter the otp</h2>
            <input type="number" name="otpverify" autocomplete="off" required
            class="border-2 border-black w-72 mx-auto p-2">
            <input type="submit" name="authenticate" value="Authenticate" class="bg-black text-white text-center mt-3 rounded-lg hover:bg-white hover:text-black mx-auto w-auto p-2">
        </form>
    </div>
</body>
</html>

<?php

$email_id =  $_POST["email"];
$msg = 'Email already exists, Try logging in!';
$sql = "SELECT * FROM finalusers WHERE Email = '$email_id'";

$search = mysqli_query($conn, $sql);
$search_res = mysqli_fetch_assoc($search);

$check_dup = $search_res["Email"];


$otp = rand(100000, 999999);
    if(isset($_POST["signup"])){

        $_SESSION['otp'] = $otp;
        if($email_id == $check_dup){
            header("Location: signup.php");
        
            $_SESSION["duplicate"] = $msg;
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