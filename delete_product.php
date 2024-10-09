<?php
// delete_product.php

// Database connection
$conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from the query string
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Redirect back to the admin page after deletion
        header("Location: admin.php?success=Product deleted successfully");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No product ID specified.";
}

$conn->close();
?>
