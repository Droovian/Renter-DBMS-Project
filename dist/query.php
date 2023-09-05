<?php
session_start();

include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
</head>
<body>
    Hello
</body>
</html>

<?php

$users_otp = $_POST["otpverify"];


$sql = "SELECT * FROM checkusers WHERE otp = '$users_otp' ";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    // echo $row["Name"] . "<br>";
    $stored_otp = $row["otp"];

    if($users_otp == $stored_otp){
        $final_name = $row["Name"];
        $final_email = $row["Email"];
        $final_password = $row["password"];

        $sql = "INSERT INTO finalusers (Name, Email, password)
                VALUES ('$final_name', '$final_email', '$final_password')";

        header("Location: login.php");
    }
    else{
        echo "Wrong!";
        // echo "<script>
        // alert('Incorrect OTP. Authentication Failed.');
        // window.location.href = 'query.php';
        // </script>";
        
    }

    try{
        mysqli_query($conn, $sql);
    }
    catch(mysqli_sql_exception){
        echo "Failed, Error occured!";
    }
}

?>