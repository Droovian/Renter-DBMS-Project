<?php
    session_start();
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="images/fox-svgrepo-com.svg">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body class="font-body bg-gray-500 sm:bg-gray-100">
    <p class="text-red-500 text-xl font-light text-center"><?php echo $_SESSION["duplicate"]; ?></p>

    <div class="p-2 m-0 w-full">
        <div class="container flex flex-row items-center space-x-4">
            <a href="signup.php" class="font-body p-2 ml-4 text-2xl font-semibold invisible sm:visible">Renter</a>
        </div>

        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-100 flex flex-row w-1/2 shadow-2xl rounded-md border-black sm:text-left">
                <div class="bg-gray-100 h-auto w-1/2 rounded-md flex flex-col">
                    <div class="flex flex-row space-x-2 mt-3 justify-center">
                        <img src="images/userfinal.svg" class="w-7" alt="user-logo">
                        <h2 class="font-bold text-xl">Sign Up</h2>
                    </div>
                    <span class="font-light p-2 text-sm mb-5 mx-auto">Please enter your details</span>
                    <div class="flex flex-col space-y-3 mt-2 p-2">
                        <form action="submitotp.php" class="flex flex-col space-y-3 p-4" method="post"
                            onsubmit="return validateForm();">
                            <label for="">Name</label>
                            <input type="name"
                                class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500"
                                placeholder="Enter your name" name="name" autocomplete="off" required>
                            <label for="">Email</label>
                            <input type="email"
                                class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500"
                                placeholder="Email" name="email" autocomplete="off" required oninput="validateForm()">
                            <p id="email-message" class="text-red-500 text-xs"></p>
                            <label for="">Phone No:</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*"
                                class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500"
                                placeholder="Phone Number" name="phoneno" oninput="validateForm()">
                            <p id="phone-message" class="text-red-500 text-xs"></p>
                            <label for="">Password</label>
                            <div class="relative mx-auto">
                            <input type="password"
                                class="p-1 max-w-sm sm:w-60 mx-auto border rounded-md focus:outline-none focus:border-blue-500"
                                placeholder="Password" name="password" id="password" autocomplete="off" required
                                oninput="validateForm()">
                                <i class="bi bi-eye-slash text-black cursor-pointer absolute top-1 right-1" id="togglePassword"></i>
                            </div>
                            <p id="password-message" class="text-red-500 text-xs"></p>
                            <input type="hidden" name="otp">
                            <div class="flex flex-col space-y-3 sm:flex-row justify-between items-center p-2">
                                <div class=" mt-2 flex space-x-2">
                                    <input type="checkbox" name="cb" id="cb">
                                    <label for="" class="text-xs font-light">Remember Me</label>
                                </div>
                                <a href="login.php" class="text-xs mt-2 font-light">Already have an account?</a>
                            </div>
                            <input type="submit" name="signup" value="Register"
                                class="bg-black text-white text-center rounded-lg hover:bg-white hover:text-black  mx-auto w-32 md:w-1/2 p-2">
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
                </div>
                <img src="images/boat.jpg" alt="boat-image" class="invisible md:visible w-1/2 rounded-md">
            </div>
        </div>
        
        <footer class="invisible sm:visible flex justify-between border-black fixed bottom-0 bg-white w-screen">
            <div class="flex flex-row text-amber-700 space-x-3 h-12 px-10 items-center">
                <a href="#" class="text-sm  hover:underline-offset-1 underline">Renter Corp™️</a>
                <a href="#" class="text-sm  hover:underline-offset-1  underline">Privacy</a>
                <a href="#" class="text-sm  hover:underline-offset-1  underline">Jobs</a>
                <a href="#" class="text-sm  hover:underline-offset-1  underline">Terms</a>
            </div>
            <div class="flex flex-row items-center space-x-4 px-10">
                <img src="images/reshot-icon-globe-PL5973EKAD.svg" class="w-5" alt="the-globe">
                <p class="text-sm">English</p>
                <p class="text-sm">₹ (INR)</p>
            </div>
        </footer>
    </div>
    <script>
    function validateEmail(email) {
        if (email === '') {
            return ''; // No feedback when the input is empty
        }

        const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        return emailPattern.test(email) ? '' : 'invalid';
    }

    function validatePhoneNumber(phoneNumber) {
        if (phoneNumber === '') {
            return ''; // No feedback when the input is empty
        }

        const phonePattern = /^\d{10}$/;
        return phonePattern.test(phoneNumber) ? '' : 'invalid';
    }

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

    function validateForm() {
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput.value.trim();
        const emailMessage = document.querySelector('#email-message');

        const phoneInput = document.querySelector('input[name="phoneno"]');
        const phoneNumber = phoneInput.value.trim();
        const phoneMessage = document.querySelector('#phone-message');

        const passwordInput = document.querySelector('input[name="password"]');
        const password = passwordInput.value;
        const passwordMessage = document.querySelector('#password-message');

        // Email validation
        const emailValidation = validateEmail(email);
        if (emailValidation === 'invalid') {
            emailMessage.textContent = 'Email is invalid';
            emailMessage.style.color = 'red';
            return false; // Prevent form submission
        } else {
            emailMessage.textContent = ''; // No feedback when the input is empty or valid
        }

        // Phone number validation
        const phoneValidation = validatePhoneNumber(phoneNumber);
        if (phoneValidation === 'invalid') {
            phoneMessage.textContent = 'Phone number is invalid';
            phoneMessage.style.color = 'red';
            return false; // Prevent form submission
        } else {
            phoneMessage.textContent = ''; // No feedback when the input is empty or valid
        }

        // Password validation
        const passwordValidation = validatePassword(password);
        if (passwordValidation === 'invalid') {
            passwordMessage.textContent = 'Password is invalid (no spaces allowed)';
            passwordMessage.style.color = 'red';
            return false; // Prevent form submission
        } else {
            passwordMessage.textContent = ''; // No feedback when the input is empty or valid
        }

        // Password strength validation
        const passwordStrength = validatePasswordStrength(password);
        if (passwordStrength === 'weak') {
            passwordMessage.textContent = 'Password is weak. Include at least one uppercase letter, one lowercase letter, one digit, no spaces and be at least 8 characters long.';
            passwordMessage.style.color = 'red';
            return false; // Prevent form submission
        }

        return true; // Allow form submission if all validations pass
    }
    </script>
</body>

</html>