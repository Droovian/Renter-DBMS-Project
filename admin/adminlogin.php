
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
        <h1 class="text-2xl font-semibold mb-4 text-center">Admin Login</h1>
        <?php
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Check if both username and password are "admin"
            if ($username === "admin" && $password === "admin") {
                // Redirect to the admin dashboard or desired page upon successful login
                header("Location: dashboard.php");
                exit();
            } else {
                // Display an error message if login fails
                echo '<p class="text-red-500 text-center mb-4">Invalid username or password. Please try again.</p>';
            }
        }
        ?>
        <form action="" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-600 font-semibold">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" autocomplete="off" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-600 font-semibold">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50 w-full">Login</button>
            </div>
        </form>
    </div>
</body>
</html>

