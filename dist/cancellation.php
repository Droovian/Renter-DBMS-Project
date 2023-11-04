<?php
session_start();
include("database.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
?>

<?php

$Fname = $_SESSION['fname'];
$cin_date = $_SESSION['cin_date'];
$cout_date = $_SESSION['cout_date'];


if(isset($_POST['cancel-submit']) && isset($_POST['property_id']) && isset($_POST['user_id'])){
    $email_ID = $_POST['email_id'];
    $User_ID = $_POST['user_id'];
   $property_ID = $_POST['property_id'];
    $OwnerEmail = $_SESSION['emaill'];

    $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rentercorp@gmail.com';
        $mail->Password = 'pmcofgzhhtnqscxf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('rentercorp@gmail.com');
        $mail->addAddress($OwnerEmail);
        $mail->isHTML(true);
        $mail->Subject = "Cancellation Request";
        $mail->Body = "
            Hello from Renter, it appears that there is a request for booking cancellation by $Fname.

            Booking Details:
            - First Name: $Fname
            - Check-In Date: $cin_date
            - Check-Out Date: $cout_date

            If you wish to approve or reject this cancellation request, please log in to your owner dashboard.
        ";

        }

        if(!$mail->send()){
            echo "
            <script>
            alert('Mail failed to send, retry');
            window.location.href = 'show.php';
            </script>
            ";
        }

        else{
            try{
            $updateSql = "UPDATE bookings SET status = 'c-request' WHERE email='$email_ID' AND id = $User_ID AND property_id='$property_ID'";
            if (mysqli_query($conn, $updateSql)) {
                echo "
                <script>
                alert('Cancellation request sent successfully!');
                window.location.href = 'show.php';
                </script>
                ";
            } else {
                echo "
                An unexpected error occured
                ";
            }
        }
        catch(Exception $e){    
            echo "$e";
        }
        }

        unset($_SESSION['fname']);
        unset($_SESSION['cin_date']);
        unset($_SESSION['cout_date']);
        unset($_SESSION['emaill']);
?>