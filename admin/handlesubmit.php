<?php
session_start();
include("../dist/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../dist/phpmailer/src/Exception.php';
require '../dist/phpmailer/src/PHPMailer.php';
require '../dist/phpmailer/src/SMTP.php';

?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];

    $property_name = trim($_POST["property_name"]);
    $property_type = trim($_POST["property_type"]);
    $rent_amount = $_POST["rent_amount"];
    $description = trim($_POST["description"]);
    $name = trim($_POST["name"]);
    $contact_number = trim($_POST["contact_number"]);
    $location = trim($_POST["location"]);
    $image = $_FILES["image"];

    // Validate required fields
    $required_fields = [
        "Property Name" => $property_name,
        "Property Type" => $property_type,
        "Monthly Rent" => $rent_amount,
        "Description" => $description,
        "Name" => $name,
        "Contact Number" => $contact_number,
        "Location" => $location,
        "Image" => $image,
        
    ];

    foreach ($required_fields as $field_name => $field_value) {
        if (empty($field_value)) {
            $errors[] = "$field_name is required.";
        }
    }

    // Validate Rent Amount as a positive number
    if (!is_numeric($rent_amount) || $rent_amount <= 0) {
        $errors[] = "Monthly Rent must be a positive number.";
    }

    // Validate Contact Number format
    if (!preg_match("/^\d{10}$/", $contact_number)) {
        $errors[] = "Invalid Contact Number. Please enter a 10-digit number.";
    }


    // Check image upload errors and size
    if ($image["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload failed. Please try again.";
    } elseif ($image["size"] > 10 * 1024 * 1024) { // 10MB limit
        $errors[] = "Image size exceeds the maximum limit (10MB).";
    }

    if (empty($errors)) {
        // Proceed with database operations
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "RENTERUSERS";
        $conn = "";
        $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $image_path = "../dist/images/" . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $image_path);

        $sql = "INSERT INTO property_listings (property_name, property_type, rent_amount, description, name, contact_number, location, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssdsssss", $property_name, $property_type, $rent_amount, $description, $name, $contact_number, $location, $image_path);

            if ($stmt->execute()) {
                $_SESSION['success-message'] = 'Data inserted successfully';
            } else {
                $_SESSION['error_messages'] = $errors;
            }

            $stmt->close();
            $conn->close();
        } 
        else {
            echo "Error preparing statement: " . $conn->error;
        }
    } 
    else {
        $_SESSION['error-messages'] = $errors;
    }
    header("Location: admin.php");
    exit();
    
} else {
    echo "Form not submitted.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handle Submission</title>
    <link rel="icon" href="../dist/images/fox-svgrepo-com.svg">
</head>
<body>
    
</body>
</html>

