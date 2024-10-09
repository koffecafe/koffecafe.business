<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoffeCafe - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php
// Check if success message exists
$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>

<header>
    <nav>
        <div class="menu-left">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Manage Products</a></li>
            </ul>
        </div>
        <div class="menu-right">
            <a href="#"><i class="fas fa-user icon"></i> Admin</a>
        </div>
    </nav>
</header>
<div class="background"></div>
<div class="admin-section">
    <h2>Product Management</h2>
    
    <!-- Form to Add New Product -->
    <form action="admin_add_product.php" method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="product_description">Description:</label>
        <textarea id="product_description" name="product_description" required></textarea>

        <label for="product_price">Price:</label>
        <input type="number" id="product_price" name="product_price" required>

        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" required>

        <button type="submit">Add Product</button>
    </form>

    <!-- List of Products with Edit/Delete Options -->
    <h3>Manage Existing Products</h3>
    <div class="product-list">
        <?php
        // Database connection here
        $conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch all products from the database
        $result = $conn->query("SELECT * FROM products");

        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-item'>";
            echo "<img src='{$row['image']}' alt='Product Image'>";
            echo "<div>";
            echo "<h4>{$row['name']}</h4>";
            echo "<p>{$row['description']}</p>";
            echo "<p>Price: $ {$row['price']}</p>";
            echo "</div>";
            echo "<div>";
            echo "<button onclick='editProduct({$row['id']})'>Edit</button>";
            echo "<button onclick='confirmDelete({$row['id']})'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Modal for Success Message -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('successModal')">&times;</span>
            <p id="successMessage"></p>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <p id="deleteMessage"></p>
            <button id="confirmDeleteButton">Confirm</button>
            <button onclick="closeModal('deleteModal')">Cancel</button>
        </div>
    </div>
</div>

<section class="footer">
            <a href="webpage_about.html"><h2>Koffe Cafe</h2></a>
            <p>At JCD Gaming, we're fueled by hard work and dedication. 
                Join us as we build a community of passionate gamers, united by our love for gaming. <br>Let's embark on this epic journey together!</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>|
                    <a href="#"><i class="fas fa-envelope"></i></a>|
                    <a href="#"><i class="fab fa-instagram"></i></a>|
                    <a href="#"><i class="fab fa-twitter"></i></a> 
                </div>

         </section>

<script>
    let productIdToDelete;

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    function confirmDelete(productId) {
        productIdToDelete = productId; // Store the product ID to delete
        document.getElementById('deleteMessage').innerText = "Are you sure you want to delete this product?";
        document.getElementById('deleteModal').style.display = "block"; // Show the delete modal
    }

    document.getElementById('confirmDeleteButton').onclick = function() {
        window.location.href = 'delete_product.php?id=' + productIdToDelete; // Redirect to delete action
    }

    // Show success modal if a success message exists
    const successMessage = "<?php echo $successMessage; ?>";
    if (successMessage) {
        document.getElementById('successMessage').innerText = successMessage;
        document.getElementById('successModal').style.display = "block"; // Show the success modal
        
        // Remove the success parameter from the URL
        const url = new URL(window.location);
        url.searchParams.delete('success'); // Remove success parameter
        window.history.replaceState({}, document.title, url); // Update the URL without reloading
    }

    // Close modals when the user clicks anywhere outside of them
    window.onclick = function(event) {
        const successModal = document.getElementById('successModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == successModal) {
            closeModal('successModal');
        }
        if (event.target == deleteModal) {
            closeModal('deleteModal');
        }
    }
</script>

</body>
</html>
