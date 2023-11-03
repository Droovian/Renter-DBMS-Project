<?php
include("../dist/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../dist/phpmailer/src/Exception.php';
require '../dist/phpmailer/src/PHPMailer.php';
require '../dist/phpmailer/src/SMTP.php';
?>


<?php

if(isset($_POST['approve_c'])){
    $bookingID = $_POST['booking_id'];
    $status = $_POST['stats'];
    $mailID = $_POST['mail'];

    if($status === 'c-request'){
        $sql = "DELETE FROM bookings where id = '$bookingID'";

        if (mysqli_query($conn, $sql)) {
            
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rentercorp@gmail.com';
            $mail->Password = 'pmcofgzhhtnqscxf';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('rentercorp@gmail.com');
            $mail->addAddress($mailID);
            $mail->isHTML(true);
            $mail->Subject = "Booking Cancelled";
            $mail->Body = "
            Booking cancellation has been approved by the owner of the property.
            ";
           
            if(!$mail->send()){
                echo "
                <script>
                alert('Mail failed to send, retry');
                window.location.href = 'c-requests.php';
                </script>
                ";
            }
            else{
                echo '
                <script>
                    alert("Booking cancelled!");
                    window.location.href= "c-requests.php";
                </script>
                ';
            }
        }
        else{
            echo "Error deleting booking with ID $bookingID: " . mysqli_error($conn);
        }
    }

}



?>