<?php
include("../dist/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../dist/phpmailer/src/Exception.php';
require '../dist/phpmailer/src/PHPMailer.php';
require '../dist/phpmailer/src/SMTP.php';

if (isset($_POST['confirm_booking'])){
    $bookingID = $_POST['booking_id'];
    $status = $_POST['confirm_booking'];  // Assuming 'confirm_booking' holds the new status
    
    // Update the status to the new value in the database
    $updateSql = "UPDATE bookings SET status = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "si", $status, $bookingID);  // Bind the correct data types
        if (mysqli_stmt_execute($updateStmt)) {
            // Status updated successfully
            mysqli_stmt_close($updateStmt);
        } else {
            // Status update failed
            echo '<p class="text-amber-500 text-center mb-4">Status update failed. Please try again later.</p>';
            exit();  // Exit the script if the update fails
        }
    }

    $emailSql = "SELECT email FROM bookings WHERE id = ?";
    $emailStmt = mysqli_prepare($conn, $emailSql);
    $email = '';

    if ($emailStmt) {
        mysqli_stmt_bind_param($emailStmt, "i", $bookingID);
        mysqli_stmt_execute($emailStmt);
        mysqli_stmt_bind_result($emailStmt, $email);

        if (mysqli_stmt_fetch($emailStmt)) {
            // $email now contains the email address of the person
            if (!empty($email)) {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rentercorp@gmail.com';
                $mail->Password = 'pmcofgzhhtnqscxf';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('rentercorp@gmail.com');
                
                // Set recipient
                $mail->addAddress($email);
                
                // Set email content
                $mail->isHTML(true);
                $mail->Subject = 'Booking Confirmation';
                $mail->Body = 'Your booking has been ' . $status . ' by the Owner.';
                
                // Send the email
                if ($mail->send()) {
                    // Email sent successfully
                    echo '<p class="text-green-500 text-center mb-4">Booking confirmation email sent successfully.</p>';
                } else {
                    // Email sending failed
                    echo '<p class="text-red-500 text-center mb-4">An Error Occured.</p>';
                }
            }
        }

        mysqli_stmt_close($emailStmt);
    }
    header("Location: dashboard.php");
    exit();
}
?>
