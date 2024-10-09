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
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            echo json_encode(["status" => "success", "role" => $role]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Email not found!"]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
