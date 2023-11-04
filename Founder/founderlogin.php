<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Renter Owner Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <?php  
    if(isset($_SESSION['foundermessage'])){
        echo $_SESSION['foundermessage'];
    }
    ?>
    <div class="bg-white p-8 rounded shadow-lg w-1/3">
        <h2 class="text-2xl font-bold mb-4 text-center">Renter Owner Login</h2>

        <form method="POST" action="founderdashboard.php" class="mt-4">
            <div class="mb-4">
                <label for="name" class="block text-gray-600 text-sm font-medium mb-2">Username:</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="rentercorphead" disabled>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 text-sm font-medium mb-2">Password:</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter your secure password" minlength="8">
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-600 text-sm font-medium mb-2">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="Re-enter the password" minlength="8">
            </div>

            <div class='form-group'>
            <div class="g-recaptcha" data-sitekey="6LfO1_MoAAAAANzLs5kdi9miomkmMwW6osN0FKd3"></div>
            </div>
            <div class="text-center">
                <input type="submit" value="Log In" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
            </div>
            
            
        </form>
    </div>
</body>

<script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
</html>
