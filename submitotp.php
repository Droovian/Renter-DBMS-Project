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
    <link rel="stylesheet" href="output.css">
</head>
<body>
    <div class="flex flex-row mx-auto border-2 border-black p-2 w-96 h-auto mt-48">
        <form action="query.php" class="flex flex-col justify-center mx-auto space-y-4" method="post">
            <h2 class="mx-auto font-light text-lg">Enter the otp</h2>
            <input type="number" name="otpverify" class="border-2 border-black w-72 mx-auto p-2">
            <input type="submit" name="authenticate" value="Authenticate" class="bg-black text-white text-center mt-3 rounded-lg hover:bg-white hover:text-black mx-auto w-auto p-2">
        </form>
    </div>
</body>
</html>

<?php
$email_id =  $_POST["email"];

$otp = rand(100000, 999999);
    if(isset($_POST["signup"])){

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dhruvnaik21@gmail.com';
        $mail->Password = 'qpfzmpkljjrmlvny';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('dhruvnaik21@gmail.com');
        $mail->addAddress($email_id);
        $mail->isHTML(true);
        $mail->Subject = "OTP(One Time Password)";
        $mail->Body = "Your OTP: " . $otp;

        if(!$mail->send()){
            echo "Error occured";
        }
else{

        if(!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])){

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $pass = $_POST["password"];
            $hash = $pass;
            
            // echo "$name, $email, $pass";
            $sql = "INSERT INTO checkusers (Name, Email, password, otp)
                    VALUES ('$name', '$email', '$hash', '$otp')";

            try{
                mysqli_query($conn, $sql);
                echo "Registered!";
                // header("Location: submitotp.php");
            }
            catch(mysqli_sql_exception){
                echo "Could not register";
            }
            mysqli_close($conn);
            
        }
        else{
            echo "Error";
        }
    }
    }


//  $mail = new PHPMailer(true);

//  $mail->isSMTP();
//  $mail->Host = 'smtp.gmail.com';
//  $mail->SMTPAuth = true;
//  $mail->Username = 'dhruvnaik21@gmail.com';
//  $mail->Password = 'qpfzmpkljjrmlvny';
//  $mail->SMTPSecure = 'ssl';
//  $mail->Port = 465;

//  $mail->setFrom('dhruvnaik21@gmail.com');
// $mail->addAddress($email_id);
// $mail->isHTML(true);
// $mail->Subject = "OTP(One Time Password)";
// $mail->Body = "Your OTP: " . $otp;

// $mail->send();

// if($otp == $user_entered_otp){
//     echo "Correct there is a match";
// }

?>