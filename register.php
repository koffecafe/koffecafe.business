<?php
// Database configuration
$host = 'localhost';  
$db = 'koffecafe';    
$user = 'KoffeCafe';  
$pass = 'hercorcollege'; 

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $role = 'client'; // Default role for clients

    if (!$email) {
        echo json_encode(["status" => "error", "message" => "Invalid email format!"]);
        exit();
    }

    // Check if the email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email is already registered. Please use a different email."]);
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Sign-up successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    }

    // Close the email check statement
    $checkEmail->close();
    exit();
}

// Close connection
$conn->close();
?>
