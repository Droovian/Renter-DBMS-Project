<?php
include("database.php");
session_start();
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
    <title>reset</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
</head>
<body>
    
</body>
</html>

<?php
if(isset($_POST['passreset'])){
    $email = $_POST['email'];
    $token = md5(rand());

    $check_email = "SELECT * FROM finalusers WHERE Email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){
        $row = mysqli_fetch_array($check_email_run);
        $name = $row['Name'];
        $email_id = $row['Email'];

        $update_token = "UPDATE finalusers SET reset_token_hash='$token' WHERE Email = '$email_id' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);

        if($update_token_run){
            send_password_reset($name, $email_id, $token);
        }
    }
    else{
        header("Location: resetpassword.php");
        echo '<h2 class="text-red-500">EMAIL DOES NOT EXIST!</h2>';
        exit(0);
    }
    
    
}

// echo $_POST['email'];
function send_password_reset($name, $email_id, $token)
{
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
    $mail->Subject = "Password Reset";
    $message_template = "
    
    <h2>Dear User,</h2>
    <p>Please click on the following link to reset your password.</p>
    <br/><br/>
    <p><a href='http://localhost/Renter/dist/changepassword.php?token=$token&email=$email_id'>Click here to reset</a></p>
    <p>Thanks,</p>
    <p>Renter Corp</p>

    ";
    $mail->Body = $message_template;

    if(!$mail->send()){
        echo "Error occured" . $mail->ErrorInfo;
    }

    else{
        echo '
        <div class="p-3">
            <div class="bg-green-200 rounded-lg p-4">
                <p class="text-green-700 text-2xl text-center font-bold font-body">Password Reset Instructions Sent</p>
                <p class="text-center text-gray-600">An email with instructions on how to reset your password has been sent to your email address. Please check your inbox and follow the instructions to reset your password.</p>
            </div>
        </div>
        ';
    }
}

if(isset($_POST['updatepass'])){

$count = 0;
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['newpassword']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirmpassword']);

    $pass_token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if(!empty($pass_token)){
        if(!empty($email) && !empty($new_password) && !empty($confirm_pass)){

            // checking token validity

            $check_token = "SELECT reset_token_hash FROM finalusers WHERE reset_token_hash='$pass_token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if(mysqli_num_rows($check_token_run) > 0){
                
                if($new_password == $confirm_pass)
                {
                    $new_pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = "UPDATE finalusers SET password='$new_pass_hash' WHERE reset_token_hash='$pass_token' LIMIT 1";
                    $update_password_run = mysqli_query($conn, $update_password);

                    if($update_password_run){
                            header("Location: login.php");
                            exit(0);
                    }
                    else{
                        echo "Something went wrong";
                        header("Location: changepassword.php?token=$pass_token&email=$email");
                        exit(0);

                    }
                }
                else{
                    header("Location: changepassword.php?token=$pass_token&email=$email");
                    $_SESSION['status'] = 'Passwords did not match';
                    exit(0);
                    
                }
            }
            else{
                $_SESSION['status'] = "Invalid Token";
                header("Location: changepassword.php?token=$pass_token&email=$email");
            exit(0);
            }
        }
        else{
            $_SESSION['status'] = "All fields are mandatory";
            header("Location: changepassword.php?token=$pass_token&email=$email");
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "No token available";
        header("Location:changepassword.php");
        exit(0);
    }
}
mysqli_close($conn);

session_destroy();
?>