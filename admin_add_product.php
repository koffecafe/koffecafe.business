<?php
session_start(); // Start the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data from the POST request
    $name = $_POST['product_name'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $image = $_FILES['product_image'];

    // Handle image upload
    $targetDir = "images/"; // Ensure this folder exists
    $targetFile = $targetDir . basename($image["name"]);

    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        // Insert product into database
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $targetFile);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Product added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add product: " . $stmt->error;
        }
    } else {
        $_SESSION['error'] = "Image upload failed.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the admin page
    header("Location: admin.php");
    exit();
}
?>
