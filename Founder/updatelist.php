<?php
include("../dist/database.php");

?>


<?php
    $id_to_check = $_POST["user_id"];
    // echo $_POST['user_id'];

    if(isset($_POST["approval"]) && isset($_POST['user_id']) && $_SERVER["REQUEST_METHOD"] == "POST"){
            $sql = "UPDATE finalusers SET lister = 1 WHERE id='$id_to_check'";

            try{
             mysqli_query($conn, $sql);
            }catch(Exception $e){
                echo "".$e->getMessage()."";
            }
            
            header("Location: founderdashboard.php");
            exit();
    }

?>