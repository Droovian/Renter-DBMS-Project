<?php
session_start();
include("database.php");
?>


<?php

$logged_users_id = $_SESSION['tocheckid'];
$check_email_db = $_SESSION['check'];

$sql = "UPDATE finalusers SET lister = 0 WHERE id='$logged_users_id' AND Email='$check_email_db'";

$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>
        alert('Request made to the admin, you will have to wait for approval.');
        window.location.href = 'index.php';
    </script>";
}
else{
    echo "<script>
        alert('A Fatal error occured.');
        window.location.href = 'index.php';
    </script>";
}


?>