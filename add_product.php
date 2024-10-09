<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Determine if it's a food or drink submission
    if (isset($_FILES['food_image'])) {
        // Handle food submission
        $name = $_POST['food_name'];
        $description = $_POST['food_description'];
        $price = $_POST['food_price'];
        $stock = $_POST['food_stock'];
        $image = $_FILES['food_image'];
        $category = 'food'; // Set category for food
    } elseif (isset($_FILES['drink_image'])) {
        // Handle drink submission
        $name = $_POST['drink_name'];
        $description = $_POST['drink_description'];
        $price = $_POST['drink_price'];
        $stock = $_POST['drink_stock'];
        $image = $_FILES['drink_image'];
        $category = 'drink'; // Set category for drink
    } else {
        echo json_encode(["success" => false, "message" => "No product type specified."]);
        exit;
    }

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        // Insert product into database
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, stock, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsis", $name, $description, $price, $targetFile, $stock, $category);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add product: " . $stmt->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Image upload failed."]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
