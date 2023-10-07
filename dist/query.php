<?php
session_start();

include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
</head>
<body>
    
</body>
</html>

<?php

$users_otp = $_POST["otpverify"];
$generated_otp = $_SESSION['otp'];

        $final_name = $_SESSION['name'];
        $final_email = $_SESSION['email'];
        $final_password = $_SESSION['hash'];
        $final_phone = $_SESSION['phone_no'];

        if($users_otp == $generated_otp){
            $sql = "INSERT INTO finalusers (Name, Email, password, phone_no)
                VALUES ('$final_name', '$final_email', '$final_password', '$final_phone')";

            try{
                mysqli_query($conn, $sql);
            }
            catch(mysqli_sql_exception){
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
            header("Location: login.php");
        }
   else{

    $msg = 'OTP did not match! Please retry';
    $_SESSION['otpfail'] = $msg;

    echo "<script>
         alert('Incorrect OTP');
        window.location.href = 'submitotp.php';
        </script>";
    
       exit();

   }
        
   




?>