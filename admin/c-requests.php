<?php
session_start();
include("../dist/database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                <a href="../admin/adminlogin.php">Dashboard</a>
            </li>
        </ul>
       
    </div>
    
    <div class="ml-64 p-4 w-full">
        <h1 class="text-2xl font-semibold mb-4">Booking Details</h1>
        <!-- Table to display booking details -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection code here
                $emailadmin = $_SESSION['email'];
                $id = $_SESSION['id'];
                // echo $emailadmin;
                // Query to retrieve booking data from the "bookings" table
                $sql = "SELECT * FROM bookings WHERE property_id='$id' AND status='c-request' ";
                $result = mysqli_query($conn, $sql);

                // Check if there are any bookings
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['propsID'] = $row['property_id'];
                        echo '<tr>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['id'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['property_id'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['name'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['email'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['check_in'] . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap">' . $row['check_out'] . '</td>';
        
                        echo '<td class="px-6 py-4 whitespace-nowrap">';
                        echo '<form method="post" action="cancelbooking.php">';
                        echo '<input type="hidden" name="booking_id" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="stats" value="' . $row['status'] . '">';
                        echo '<input type="hidden" name="mail" value="' . $row['email'] . '">';
                        echo '<button type="submit" name="approve_c" class="bg-black text-white px-3 py-2 rounded">Approve</button><br><br>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="px-6 py-4 whitespace-nowrap">No cancellation requests found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
