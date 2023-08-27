<?php

include("database.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
</head>
<body class="font-body">
    <div class="p-2 m-0 w-full flex flex-row justify-between items-center">
       <div class="container flex flex-row items-center space-x-4">
        <img src="images/fox-svgrepo-com.svg" alt="logo" class="w-10">
        <a href="/" class="text-amber-700 text-2xl font-bold ">Renter</a>
       </div>

       <div class="mr-5">
        <button class="cursor-pointer" id="dropbutton">
            <img src="images/more.png" class="w-10 p-1 hover:rotate-90 "alt="three-dots">
        </button>
        </div>
    </div>
 <div class="flex flex-row justify-end mr-11">
    <div class="bg-black text-white font-light w-48 h-auto absolute flex-col space-y-1 rounded-lg border-2 border-grey-400  p-3 drop-shadow-lg hidden" id="container">
        <a href="#">About Us</a>
        <hr>
        <a href="#">Support</a>
        <hr>
        <a href="#">Email</a>
    </div>

    </div>
   
    <div class="flex items-center justify-center min-h-screen w-full md:min-w-md">
        <div class="flex flex-row mx-auto h-auto w-full md:w-1/2 shadow-2xl rounded-md border-black">
            <div class="ml-32 h-auto w-full flex flex-col justify-center md:w-1/2 md:ml-0 rounded-md  mb-10">
                <div class="flex flex-row space-x-2 mt-3 justify-center">
                    <img src="images/userfinal.svg" class="w-7" alt="user-logo">
                    <h2 class="font-bold text-xl">Login</h2>
                </div>
                <span class="font-light p-2 text-sm mb-5 mx-auto">Please enter your details</span>

                <div class="flex flex-col space-y-3 mt-2 p-2">
                    <form action="login.php" class="flex flex-col space-y-3" method="post">
                    <label for="" class="">Email</label>
                    <input type="email" class="p-1 w-60 mx-auto border-2 border-grey-700 items-center" placeholder="Email" name="email" autocomplete="off" required>
                    <label for="" class="">Password</label>
                    <input type="password" class="p-1 w-60 mx-auto border-2 border-grey-700" placeholder="Password" name="password" autocomplete="off" required>
                    <div class="flex flex-col justify-between space-y-3 items-center p-2  md:flex-row md:items-center">
                        <div class="flex items-center space-x-2 md:mr-24 ">
                            <input type="checkbox" name="cb" id="cb">
                            <label for="cb" class="text-xs font-light">Remember Me</label>
                        </div>
                        
                        <button class="text-xs font-light md:text-center p-2 hover:cursor-pointer">Forgot Password</button>
                             
                    </div>
                    <input type="submit" name="login" value="Log In" class="bg-black text-white text-center rounded-lg hover:bg-white hover:text-black md:w-1/2 mx-auto p-2">
                </form>
                </div>
            
                <a href="signup.php" class="relative text-white bg-black mt-3 hover:text-black hover:bg-white text-center rounded-lg mx-auto md:w-1/2 p-2">Sign Up</a>
            
            </div>
    
            <img src="images/mountaing.jpg" alt="maldives image" class="invisible md:visible h-auto w-1/2 rounded-md">
        </div>
    </div>
</body>
<script src="script.js" defer></script>

</html>


<?php

    if(isset($_POST['login'])){
        $users_email = $_POST['email'];
        $users_password = $_POST['password'];

        $sql = "SELECT * FROM finalusers WHERE Email = '$users_email' AND password = '$users_password' ";

        $query_result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query_result) > 0){
            $user_data = mysqli_fetch_assoc($query_result);

            $email_db = $user_data["Email"];
            $pass_db = $user_data["password"];

            if(($users_email == $email_db) && ($users_password == $pass_db)){
                header("Location: index.php");
                echo "Successful!";
            }
            else{
                echo "An error occured";
            }

            try{
                mysqli_query($conn, $sql);
            }
            catch(mysqli_sql_exception){
                echo "Login failed";
                exit();
            }
        }

    }

?>