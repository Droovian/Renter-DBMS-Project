<?php
session_start();
include("database.php");

$err_msg = "Either Email entered or Password was incorrect.";

if (isset($_POST['login'])) {
    $users_email = $_POST['email'];
    $users_password = $_POST['password'];

    $sql = "SELECT * FROM finalusers WHERE Email = '$users_email'";
    $query_result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_result) > 0) {
        $user_data = mysqli_fetch_assoc($query_result);
        $name_db = $user_data["Name"];
        $email_db = $user_data["Email"];
        $pass_db = $user_data["password"];
        $users_log_id = $user_data["id"];

        if (($users_email == $email_db) && password_verify($users_password, $pass_db)) {
            $_SESSION['username'] = $name_db;
            $_SESSION["check"] = $email_db;
            $_SESSION['tocheckid'] = $users_log_id;
            header("location: index.php");
            exit();
        } else {
            echo '<script>
                alert("Either Email or Password is Incorrect");
                window.location.href = "login.php";
            </script>';
        }

        try {
            mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            echo "Login failed";
            exit();
        }
    } else {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
</head>

<body class="font-body sm:bg-gray-100">
    <div class="p-2 m-0 w-full flex flex-row justify-between items-center">
        <div class="container flex flex-row items-center space-x-4">
            <a href="/" class="font-body ml-4 text-2xl font-semibold invisible sm:visible">Renter</a>
        </div>

        <div class="mr-5">
            <button class="cursor-pointer" id="sidebarToggle">
                <img src="images/more.png" class="w-10 p-1" alt="three-dots">
            </button>
        </div>
    </div>

    <div id="sidebar"
        class="fixed inset-y-0 right-0 w-64 h-screen bg-white border-l border-gray-300 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div id="sidebarHeader" class="bg-black text-white p-4">
            <h2 class="text-2xl font-semibold font-body">Dashboard</h2>
        </div>

        <div id="sidebarContent" class="flex flex-col space-y-5 p-4 h-full">
            <p class="mt-2 font-light text-center">Are you a Property Owner?</p>
            <button
                class=" text-white bg-amber-500 font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <a href="../admin/adminlogin.php">Login</a>
            </button>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarHeader = document.getElementById('sidebarHeader');
        const sidebarContent = document.getElementById('sidebarContent');

        function toggleSidebar() {
            sidebar.classList.toggle('translate-x-full');
        }

        sidebar.classList.add('translate-x-full');

        sidebarToggle.addEventListener('click', toggleSidebar);

        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.add('translate-x-full');
        });
    </script>

    <div class="bg-gray-100 flex items-center justify-center min-h-screen ">
        <div class="bg-gray-100 flex flex-row mx-auto w-1/2 shadow-2xl rounded-md border-black">
            <div class="p-3 sm:p-0 bg-gray-100 flex flex-col justify-center rounded-md">
                <div class="flex flex-row space-x-2 mt-3 justify-center">
                    <img src="images/userfinal.svg" class="w-7" alt="user-logo">
                    <h2 class="font-bold text-xl">Login</h2>
                </div>
                <span class="font-light p-2 text-sm mb-5 mx-auto">Please enter your details</span>

                <div class="flex flex-col space-y-3 mt-2 p-2">
                    <form action="login.php" class="flex flex-col space-y-3" method="post"
                        onsubmit="return validateForm();">
                        <label for="email" class="">Email</label>
                        <input type="email" class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500"
                            placeholder="Email" name="email" autocomplete="off" required oninput="validateForm()">
                        <p id="email-message" class="text-red-500 text-xs"></p>
                        <label for="password" class="">Password</label>
                        <div class="relative mx-auto">
                            <input type="password" class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500" placeholder="Password" name="password" id="password" autocomplete="off" required>
                            <i class="bi bi-eye-slash text-black cursor-pointer absolute top-1 right-1" id="togglePassword"></i>
                        </div>
                        <div class="flex flex-col justify-between space-y-3 items-center p-2  md:flex-row md:items-center">
                            <div class="flex items-center space-x-2 md:mr-24 ">
                                <input type="checkbox" name="cb" id="cb">
                                <label for="cb" class="text-xs font-light">Remember Me</label>
                            </div>

                            <a href="resetpassword.php" class="text-xs font-light md:text-center p-2 hover:cursor-pointer">Forgot Password</a>
                        </div>
                        <input type="submit" name="login" value="Log In"
                            class="bg-black text-white text-center rounded-lg hover:bg-gray-100 hover:text-black md:w-1/2 mx-auto p-2">
                    </form>
                </div>

                <script>
                    const togglePassword = document.querySelector("#togglePassword");
                    const password = document.querySelector("#password");

                    togglePassword.addEventListener("click", () => {
                        const type = password.getAttribute("type") === "password" ? "text" : "password";
                        password.setAttribute("type", type);
                        togglePassword.classList.toggle("bi-eye");
                        togglePassword.classList.toggle("bi-eye-slash");
                    });
                </script>
                <a href="signup.php"
                    class="relative text-white bg-black mt-3 hover:text-black hover:bg-gray-100 text-center rounded-lg mx-auto md:w-1/2 p-2">Sign Up</a>

            </div>

            <img src="images/mountaing.jpg" alt="mountain-img"
                class="ml-auto invisible sm:invisible md:visible h-auto w-1/2 md:object-cover lg:object-cover rounded-md">
        </div>
    </div>

    <script>
        function validateEmail(email) {
            if (email === '') {
                return ''; // No feedback when the input is empty
            }

            const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
            return emailPattern.test(email) ? '' : 'invalid';
        }

        function validateForm() {
            const emailInput = document.querySelector('input[name="email"]');
            const email = emailInput.value.trim();
            const emailMessage = document.querySelector('#email-message');

            // Email validation
            const emailValidation = validateEmail(email);
            if (emailValidation === 'invalid') {
                emailMessage.textContent = 'Email is invalid';
                emailMessage.style.color = 'red';
            } else {
                emailMessage.textContent = ''; // No feedback when the input is empty or valid
            }
        }

    </script>
</body>

<footer
    class="invisible sm:visible flex justify-between border-black fixed bottom-0 bg-white w-screen">
    <div class="flex flex-row space-x-3 h-12 px-10 items-center">
        <a data-modal="renter"
            class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1 underline">Renter Corp™️</a>
        <a 
            class="text-sm text-amber-700 hover:text-amber-800 hover:underline-offset-1  underline"
            href="../Founder/founderlogin.php"
            >Administrator</a>
    </div>
    <div class="flex flex-row items-center space-x-4 px-10">
        <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">

    </div>
</footer>

</html>