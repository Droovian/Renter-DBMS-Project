<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

   <a href="../dist/login.php" class="bg-amber-500 text-white py-2 px-4 rounded-md hover:bg-amber-600 focus:outline-none focus:bg-blue-600 absolute top-4 left-4">Back to Home</a>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
        <h1 class="text-2xl font-semibold mb-4 text-center">Owner Login</h1>
        <?php
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $id = $_POST["id"];

            // Establish a database connection
            $db_server = "localhost";
            $db_user = "root";
            $db_password = "";
            $db_name = "RENTERUSERS";
            $conn = new mysqli($db_server, $db_user, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query the property_listings table
            $sql = "SELECT * FROM property_listings WHERE email = ? AND id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("si", $email, $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    // Redirect to dashboard.php if a matching user is found
                    $_SESSION['email'] = $email;
                    $_SESSION['id'] = $id;
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Display an error message if no matching user is found
                    echo '<p class="text-red-500 text-center mb-4">Invalid Email or ID. Please try again.</p>';
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }

            $conn->close();
        }
        ?>
        <form action="" method="post">
            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-semibold">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <label for="id" class="block text-gray-600 font-semibold">ID</label>
                <input type="text" id="id" name="id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-amber-500 focus:ring-opacity-50 w-full">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
