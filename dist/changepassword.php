<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-gray-100">

    <p class="text-red-500 text-xl text-center"><?php  if(isset($_SESSION['status'])){echo $_SESSION['status'];} ?></p>
    <div class="bg-white w-1/2 h-auto border border-gray-400 rounded-sm mx-auto mt-32 p-3">
        <div class="flex justify-between">
        <div class="text-2xl my-auto text-amber-700">Change Password</div>
        <img src="./images/fox.jpg" class="w-16" alt="">
        </div>
        <hr>
        <form action="resetcode.php" method="post" class="flex flex-col space-y-4">
            <input type="hidden" name="password_token"value="<?php if(isset($_GET['token'])){echo $_GET['token']; } ?>">
            <label for="">Email Address</label>
            <input type="email" name="email" autocomplete="off" value="<?php if(isset($_GET['email'])){echo $_GET['email']; } ?>" placeholder="Enter Email Address" class="p-2 border border-gray-400 rounded-md">
            <label for="">New Password</label>
            <input type="password" name="newpassword" autocomplete="off" placeholder="Enter New Password" class="p-2 border border-gray-400 rounded-md" oninput="validateForm()" >
            <p id="password-message" class="text-red-500 text-xs"></p>
            <label for="">Confirm Password</label>
            <input type="password" placeholder="Enter Confirm Password" autocomplete="off" name="confirmpassword" class="p-2 border border-gray-400 rounded-md">
            <button type="submit" name="updatepass" class="w-full p-3 mx-auto rounded-lg bg-amber-500 text-white font-light mb-5 hover:bg-amber-300">Update Password</button>
        </form>
    </div>
    <script>
    function validatePassword(password) {
        if (password === '') {
            return ''; // No feedback when the input is empty
        }

        return !/\s/.test(password) ? '' : 'invalid';
    }
    function validatePasswordStrength(password) {
        if (password === '') {
            return ''; // No feedback when the password is empty
        }

        // Define password strength criteria
        const minLength = 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasDigit = /\d/.test(password);
        const hasNoSpace = !/\s/.test(password);

        if (password.length < minLength || !hasUppercase || !hasLowercase || !hasDigit || !hasNoSpace) {
            return 'weak';
        }

        return 'strong';
    }

    function validateForm(){
    const passwordInput = document.querySelector('input[name="newpassword"]');
    const password = passwordInput.value;
    const passwordMessage = document.querySelector('#password-message');
    const passwordStrength = validatePasswordStrength(password);
        if (passwordStrength === 'weak') {
            passwordMessage.textContent = 'Password is weak. Include at least one uppercase letter, one lowercase letter, one digit, no spaces and be at least 8 characters long.';
            passwordMessage.style.color = 'red';
            return false; // Prevent form submission
        }
    const passwordValidation = validatePassword(password);
        if (passwordValidation === 'invalid') {
            passwordMessage.textContent = 'Password is invalid (no spaces allowed)';
            passwordMessage.style.color = 'red';
            return false; // Prevent form submission
        } 
        else {
            passwordMessage.textContent = ''; // No feedback when the input is empty or valid
        }
    }
    </script>
</body>
</html>


