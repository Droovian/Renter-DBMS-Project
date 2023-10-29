<?php
session_start();
include("../dist/database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Reviews</title>
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 260px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar li {
            padding: 10px 20px;
            border-left: 3px solid transparent;
        }
        .sidebar li:hover {
            background-color: #F3F4F6;
            border-left-color: #F59E0B;
        }
    </style>
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div class="sidebar bg-white h-screen fixed top-0 left-0 overflow-y-auto">
        <ul>
            <li class="text-gray-600 hover:text-amber-500">
                <a href="../admin/dashboard.php">Go Back</a>
            </li>
            <!-- Add other sidebar links here -->
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="ml-64 p-4 w-full">
        <h1 class="text-2xl font-semibold mb-4">Property Reviews for Property ID: <?php echo $_SESSION['propsID']; ?></h1>
        <!-- Center the table -->
        <div class="mx-auto max-w-7xl">
            <!-- Table to display property reviews -->
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to retrieve reviews for the specific property
                    $propertyID = $_SESSION['propsID'];
                    $sql = "SELECT * FROM reviews WHERE property_id='$propertyID'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['review_id'] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['user_id'] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['rating'] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['description'] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['review_date'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="px-6 py-4 whitespace-nowrap">No reviews found for this property.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
