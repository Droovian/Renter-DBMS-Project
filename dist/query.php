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

$msg = 'OTP did not match! Please retry';
$users_otp = $_POST["otpverify"];

$sql = "SELECT * FROM checkusers WHERE otp = '$users_otp' ";

$result = mysqli_query($conn, $sql);

if(!$result){
    echo 'Database query error: '.mysqli_error($conn) . 'Redirecting...';
    echo '<script>
                    setTimeout(function() {
                    window.location.href = "signup.php";
                    }, 3000);
         </script>';
}

 else if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    // echo $row["Name"] . "<br>";
    $stored_otp = $row["otp"];

        $final_name = $row["Name"];
        $final_email = $row["Email"];
        $final_password = $row["password"];
        $final_phone = $row["phone_no"];
        $sql = "INSERT INTO finalusers (Name, Email, password, phone_no)
                VALUES ('$final_name', '$final_email', '$final_password', '$final_phone')";

    try{
        mysqli_query($conn, $sql);
    }
    
    catch(mysqli_sql_exception){
        echo "Failed, Error occured!";
    }
        header("Location: login.php");
 }
   else{

    $_SESSION['otpfail'] = $msg;

    echo "<script>
         alert('Incorrect OTP');
        window.location.href = 'submitotp.php';
        </script>";
    
       exit();

   }
        
   




?>