<?php

include("../dist/database.php");

?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $founderPassword = "1234567890";

    if (isset($_POST["password"]) && $_POST["password"] === $_POST["confirm_password"] && $_POST["password"] === $founderPassword) {
        setcookie("founderLoggedIn", "true", time() + 3600); 

        header("Location: founderdashboard.php");
        exit;
    } else {
        echo "<script>
        alert('Incorrect password or passwords do not match. Please try again.');
        window.location.href = 'founderlogin.php';
        </script>";
        
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Founder Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            background: #333;
            width: 250px;
            position: fixed;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            padding: 16px;
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        .content {
            margin-left: 260px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="sidebar">
        <a href="founderlogin.php" class="text-center text-white p-4 bg-blue-500">Back to Login</a>
    </div>
    <div class="content ml-64 p-8">
        <h2 class="text-2xl font-bold mb-4">Founder Dashboard</h2>

        <table class="min-w-full border rounded-lg">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Listing Status</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch users from the finalusers table
                $sql = "SELECT id, Name, Email, phone_no, lister FROM finalusers";

                // Execute the query
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='px-4 py-2'>" . $row["Name"] . "</td>";
                        echo "<td class='px-4 py-2'>" . $row["Email"] . "</td>";
                        echo "<td class='px-4 py-2'>" . $row["phone_no"] . "</td>";
                        echo "<td class='px-4 py-2'>";

                        if ($row["lister"] === '0') {
                            echo '<form method="POST" action="updatelist.php">';
                            echo '<input type="hidden" name="user_id" value="' . $row["id"] . '">';
                            echo '<button name="approval" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">Approve</button>';
                            echo '</form>';
                        }
                        if($row["lister"] == 1){
                            echo "Approved";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='px-4 py-2'>No users found.</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
