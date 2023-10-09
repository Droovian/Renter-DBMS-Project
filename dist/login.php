<?php
session_start();
include("database.php");

?>

<?php
$err_msg = "Either Email entered or Password was incorrect.";

    if(isset($_POST['login'])){
        $users_email = $_POST['email'];
        $users_password = $_POST['password'];

        $sql = "SELECT * FROM finalusers WHERE Email = '$users_email'";

        $query_result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query_result) > 0){
            $user_data = mysqli_fetch_assoc($query_result);

            $name_db = $user_data["Name"];
            $email_db = $user_data["Email"];
            $pass_db = $user_data["password"];

            if(($users_email == $email_db) && password_verify($users_password, $pass_db)){
                $_SESSION['username'] = $name_db;
                $_SESSION["check"] = $email_db;
                header("location: index.php");
                exit();
            }

            else{
                echo '<script>
                alert("Either Email or Password is Incorrect");
                window.location.href = "login.php";
                </script>';
            }

            try{
                mysqli_query($conn, $sql);
            }
            catch(mysqli_sql_exception $e){
                echo "Login failed";
                exit();
            }
        }
        else{
            echo '<script>
            alert("You are not registered. Please sign up first.");
            window.location.href = "login.php"; // Replace with the registration page URL
            </script>';
        }
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-body sm:bg-gray-100">
    <div class="p-2 m-0 w-full flex flex-row justify-between items-center">
       <div class="container flex flex-row items-center space-x-4">
        <a href="/" class="font-body ml-4 text-2xl font-semibold invisible sm:visible">Renter</a>
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
   
    <div class="bg-gray-100 flex items-center justify-center min-h-screen ">
        <div class="bg-gray-100 flex flex-row mx-auto w-1/2 shadow-2xl rounded-md border-black">
            <div class="p-3 sm:p-0 bg-gray-100 flex flex-col justify-center rounded-md">
                <div class="flex flex-row space-x-2 mt-3 justify-center">
                    <img src="images/userfinal.svg" class="w-7" alt="user-logo">
                    <h2 class="font-bold text-xl">Login</h2>
                </div>
                <span class="font-light p-2 text-sm mb-5 mx-auto">Please enter your details</span>

                <div class="flex flex-col space-y-3 mt-2 p-2">
                    <form action="login.php" class="flex flex-col space-y-3" method="post">
                    <label for="email" class="">Email</label>
                    <input type="email" class="p-1 w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Email" name="email" autocomplete="on" required>
                    <label for="password" class="">Password</label>
                    <input type="password" class="p-1 w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Password" name="password" autocomplete="off" required>
                    <div class="flex flex-col justify-between space-y-3 items-center p-2  md:flex-row md:items-center">
                        <div class="flex items-center space-x-2 md:mr-24 ">
                            <input type="checkbox" name="cb" id="cb">
                            <label for="cb" class="text-xs font-light">Remember Me</label>
                        </div>
                        
                        <a href="resetpassword.php"class="text-xs font-light md:text-center p-2 hover:cursor-pointer">Forgot Password</a>
                             
                    </div>
                    <input type="submit" name="login" value="Log In" class="bg-black text-white text-center rounded-lg hover:bg-gray-100 hover:text-black md:w-1/2 mx-auto p-2">
                </form>
                </div>
            
                <a href="signup.php" class="relative text-white bg-black mt-3 hover:text-black hover:bg-gray-100 text-center rounded-lg mx-auto md:w-1/2 p-2">Sign Up</a>
            
            </div>
    
            <img src="images/mountaing.jpg" alt="mountain-img" class="ml-auto invisible sm:invisible md:visible h-auto w-1/2 md:object-cover lg:object-cover rounded-md">
        </div>
    </div>
</body>
<footer class="invisible sm:visible flex justify-between border-black fixed bottom-0 bg-white w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Privacy</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Jobs</a>
        <a href="#" class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline">Terms</a>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
        
    </div>
</footer>
<script src="script.js" defer></script>

</html>