<?php
session_start();
// Check if the user is not an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: unauthorized.php"); // Redirect to unauthorized access page if user is not an admin
    exit();
}

// Database config
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $add_ons = $conn->real_escape_string($_POST['add_ons']);
    $price_regular = $conn->real_escape_string($_POST['price_regular']);
    $price_large = $conn->real_escape_string($_POST['price_large']);
    $price_add_ons = $conn->real_escape_string($_POST['price_add_ons']);

    // SQL query to insert new beverage
    $sql = "INSERT INTO beverages (name, add_ons, price_regular, price_large, price_add_ons)
            VALUES ('$name', '$add_ons', '$price_regular', '$price_large', '$price_add_ons')";

    if ($conn->query($sql) === TRUE) {
        $message = "Beverage added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/headerStyle.css">
    <link rel="stylesheet" href="../Styles/add_beverage.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Add Beverage - Admin Dashboard</title>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <nav>
            <div class="header-top">
                <div class="contact-info">
                    <span class="phone-number">
                        <img src="../Assets/icons/phone-call.png" alt="Phone" /> +941 122 5580
                    </span>
                </div>
                <img src="../Assets/logo.jpg" alt="The Gallery Café" class="logo" />
                <div class="header-right">
                    <a href="#" class="search">
                        <img src="../Assets/icons/search.png" alt="Search" />
                    </a>

                    <a href="../Pages/cart.php" class="cart">
                        <img src="../Assets/icons/shopping-cart.png" alt="Cart" />
                    </a>

                    <?php if (!isset($_SESSION['role'])): ?>
                        <a href="../Pages/login.php" class="register">
                            <img src="../Assets/icons/register.png" alt="Login" /> Login
                        </a>
                    <?php else: ?>
                        <a href="../Pages/user.html" class="register">
                            <img src="../Assets/icons/register.png" alt="User" />
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role'])): ?>
                        <a href="../Pages/logout.php" class="register">
                            Logout
                        </a>
                    <?php endif; ?>

                </div>
            </div>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="./menu.php">Menu</a></li>
                <li><a href="./reservation.php">Reservations</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="./admin.php">Dashboard</a></li>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>
                    <li><a href="./staff.php">Dashboard</a></li>
                <?php endif; ?>

                <li><a href="./aboutUs.php">About Us</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>

    <!-- admin-container -->
    <div class="admin-main-content ">
        <div class="admin-container">
            <h1>Add New Beverage</h1>
            <?php if ($message): ?>
                <p class="admin-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="add_ons">Add-ons:</label>
                <textarea id="add_ons" name="add_ons"></textarea>

                <label for="price_regular">Price (Regular):</label>
                <input type="number" id="price_regular" name="price_regular" step="0.01" required>

                <label for="price_large">Price (Large):</label>
                <input type="number" id="price_large" name="price_large" step="0.01" required>

                <label for="price_add_ons">Price (Add-ons):</label>
                <input type="number" id="price_add_ons" name="price_add_ons" step="0.01" required>

                <button type="submit" class="admin-button">Add Beverage</button>
            </form>
        </div>
    </div>



    <!-- footer-section -->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>The Gallery Café</h2>
                <p>
                    Welcome to The Gallery Café, where we blend the love for art and
                    food. Enjoy our carefully curated menu and the artistic ambiance.
                </p>
            </div>
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../Pages/menu.html">Menu</a></li>
                    <li><a href="../Pages/reservation.html">Reservations</a></li>
                    <li><a href="../Pages/aboutUs.html">About Us</a></li>
                    <li><a href="../Pages/contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Contact Us</h2>
                <ul>
                    <li>Email: info@gallerycafe.com</li>
                    <li>Phone: +1 234 567 890</li>
                    <li>Address: 123 Art St, Creativity City</li>
                </ul>
                <div class="social-media" style="margin-top: 10px">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>