<?php
// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'gym_project';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $phone = sanitize_input($_POST["phone"]);
    $address = sanitize_input($_POST["address"]);
    $duration = sanitize_input($_POST["duration"]);
    
    // Additional validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($phone) || !preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Valid phone number is required (10-15 digits)";
    }
    
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    
    if (empty($duration) || !in_array($duration, ['6', '12', '24'])) {
        $errors[] = "Valid membership duration is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO members_form (name, email, phone, address, duration_months, join_date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $duration);
        
        // Execute
        if ($stmt->execute()) {
            // Success - redirect to thank you page
            header("Location: thank_you.html");
            exit();
        } else {
            $errors[] = "Error saving your information. Please try again.";
        }
        
        $stmt->close();
    }
    
    // If there were errors, show them
    if (!empty($errors)) {
        echo "<h2>Error:</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '<p><a href="join_now.html">Go back to the form</a></p>';
    }
}

$conn->close();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>