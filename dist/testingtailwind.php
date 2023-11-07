<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <style>
        /* Center the outer container vertically and horizontally */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body class='bg-gray-100'>
<div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl">
    <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image: url('https://images.unsplash.com/photo-1606660265514-358ebbadc80d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1575&q=80');"></div>

    <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">

        <p class="mt-3 text-xl text-center text-gray-600 dark:text-gray-200">
             Please enter your details
        </p>
        <div class="flex items-center justify-between mt-4">
            <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>

            <a href="#" class="text-xs text-center text-gray-500 uppercase dark:text-gray-400 hover:underline">sign-up</a>

            <span class="w-1/5 border-b dark:border-gray-400 lg:w-1/4"></span>
        </div>

        <form action="submitotp.php" class="flex flex-col space-y-3 p-4" method="post" onsubmit="return validateForm();">
        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="name">Name</label>
            <input type="name" name="name" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" />
        </div>

        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="email">Email</label>
            <input type="email" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" oninput="validateForm()"/>
            <p id="email-message" class="mt-1 text-xs"></p>
        </div>

        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="phoneno">Phone no</label>
            <input type="text" inputmode="numeric" pattern="[0-9]*" name="phoneno" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" oninput="validateForm()"/>
            <p id="phone-message" class="mt-1 text-red-500 text-xs"></p>
        </div>
        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password">Password</label>
            <div class="relative mx-auto">
            <input type="password" name="password" id="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" oninput="validateForm()" />
            <i class="mt-1 mr-1 bi bi-eye-slash text-white cursor-pointer absolute top-1 right-1" id="togglePassword"></i>
            </div>
            <p id="password-message" class="mt-1 text-red-500 text-xs"></p>
        </div>
        <div class="mt-6">
            <input type="submit" name="signup" value="Register" class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50"/>
        </div>
        </form>
        <div class="flex items-center justify-between mt-4">
            <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

            <a href="login.php" class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline">or log in</a>

            <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
        </div>
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
</body>

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
            passwordMessage.textContent = 'Password is weak.';
            passwordMessage.style.color = 'red';
            return false; // Prevent form submission
        }

        return true; // Allow form submission if all validations pass
    }
    </script>
    
</html>