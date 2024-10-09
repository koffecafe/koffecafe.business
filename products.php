<?php
$conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch foods
$sqlFoods = "SELECT id, name, description, price, image, stock FROM products WHERE category='food'";
$resultFoods = $conn->query($sqlFoods);

// Fetch drinks
$sqlDrinks = "SELECT id, name, description, price, image, stock FROM products WHERE category='drink'";
$resultDrinks = $conn->query($sqlDrinks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .product {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: calc(25% - 40px);
            box-sizing: border-box;
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<h1>Available Products</h1>

<h2>Foods</h2>
<div class="products">
    <?php
    if ($resultFoods->num_rows > 0) {
        while($row = $resultFoods->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Price: $" . number_format($row['price'], 2) . "</p>";
            echo "<p>Stock: " . $row['stock'] . "</p>";
            echo "<button onclick=\"addToCart(" . $row['id'] . ")\">Add to Cart</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No foods found.</p>";
    }
    ?>
</div>

<h2>Drinks</h2>
<div class="products">
    <?php
    if ($resultDrinks->num_rows > 0) {
        while($row = $resultDrinks->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Price: $" . number_format($row['price'], 2) . "</p>";
            echo "<p>Stock: " . $row['stock'] . "</p>";
            echo "<button onclick=\"addToCart(" . $row['id'] . ")\">Add to Cart</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No drinks found.</p>";
    }
    ?>
</div>

<script>
function addToCart(productId) {
    alert("Product " + productId + " added to cart!"); // Placeholder for cart functionality
}
</script>

</body>
</html>

<?php
$conn->close();
?>
