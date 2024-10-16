<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoffeCafe</title>
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="background"></div> <!-- Fixed background image -->
         <div class="content"> <!-- Content wrapper -->
        <header>
            <nav>
                <div class="menu-left">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Contacts</a></li>
                    </ul>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="menu-right">
                    <a href="#"><i class="fas fa-shopping-cart icon"></i></a>
                    <a href="#"><i class="fas fa-user icon"></i></a>
                </div>
            </nav>
        </header>

        <!-- Slider Section -->
        <div class="product-slider-container">
            <div class="slider">
                <?php
                // Establish database connection
                $conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch up to 5 products for the slider
                $result = $conn->query("SELECT * FROM products LIMIT 5");

                // Display the fetched products in the slider
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='slide'>";
                        echo "<img src='{$row['image']}' alt='Product'>";
                        echo "<div class='description'>";
                        echo "<h3>{$row['name']}</h3>";
                        echo "<p>{$row['description']}</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products available</p>";
                }

                $conn->close();
                ?>
            </div>
            <!-- Left and Right arrows -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <!-- Boxes Section -->
        <div class="boxes-section">
            <?php
            // Establish database connection
            $conn = new mysqli('localhost', 'KoffeCafe', 'hercorcollege', 'koffecafe');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch all products for the boxes section
            $result = $conn->query("SELECT * FROM products");

            // Display the products in box format
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='box' onclick=\"location.href='#{$row['name']}';\">";
                    echo "<img src='{$row['image']}' alt='{$row['name']}'>";
                    echo "<h3>{$row['name']}</h3>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products available</p>";
            }

            $conn->close();
            ?>
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
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlides(index) {
            if (index >= slides.length) {
                slideIndex = 0;
            } else if (index < 0) {
                slideIndex = slides.length - 1;
            } else {
                slideIndex = index;
            }

            // Move the slider to the appropriate slide
            const slider = document.querySelector('.slider');
            slider.style.transform = `translateX(-${slideIndex * 100}%)`;
        }

        function plusSlides(n) {
            showSlides(slideIndex + n);
        }

        // Initially show the first slide
        showSlides(slideIndex);
    </script>
</body>
</html>
