<?php
session_start();
include("../dist/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../dist/phpmailer/src/Exception.php';
require '../dist/phpmailer/src/PHPMailer.php';
require '../dist/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];

    echo $_POST['location'];
    $property_name = trim($_POST["property_name"]);
    $property_type = trim($_POST["property_type"]);
    $rent_amount = $_POST["rent_amount"];
    $description = trim($_POST["description"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]); // Added email field
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
        "Email" => $email,
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

    // Validate Email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address.";
    }

    // Check image upload errors and size
    if ($image["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload failed. Please try again.";
    } elseif ($image["size"] > 5 * 1024 * 1024) { 
        $errors[] = "Image size exceeds the maximum limit (5MB).";
    }

    if (empty($errors)) {
        // Proceed with database operations
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "RENTERUSERS";
        $conn = "";
        $conn = new mysqli($db_server, $db_user, $db_password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $image_path = "../dist/images/" . basename($image["name"]);
        move_uploaded_file($image['tmp_name'], $image_path);

       
        $sql = "INSERT INTO property_listings (property_name, property_type, rent_amount, description, name, email, contact_number, location, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssdssssss", $property_name, $property_type, $rent_amount, $description, $name, $email, $contact_number, $location, $image_path);

            if ($stmt->execute()) {
                $_SESSION['success-message'] = 'Data inserted successfully';

                $sql = "SELECT id FROM property_listings WHERE email='$email' AND property_name='$property_name'";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);

                    $property_id_of_user = $row['id'];

                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rentercorp@gmail.com';
                    $mail->Password = 'pmcofgzhhtnqscxf';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('rentercorp@gmail.com');
                    
                    // Set recipient
                    $mail->addAddress($email);
                    
                    // Set email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Property listing successful';
                    $mail->Body = "
                    <p>Property has successfully listed with us.</p>
                    <p>Your Property ID is : '$property_id_of_user'</p>
                    <br/><br/>
                    <p>Thanks for working with us</p>
                    <p>Renter Corp</p>
                    ";

                    $mail->send();

                    if(!$mail->send()){
                        echo "Mail did not send";
                    }
                }

            } else {
                $_SESSION['error_messages'] = $errors;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
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
