<?php
session_start();

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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Bind result
        $stmt->bind_result($hashed_password, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($pass, $hashed_password)) {
            
            // Start session and set user role
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $role;

            // Redirect based on role
            switch ($role) {
                case 'admin':
                case 'staff':
                case 'customer':
                    header("Location: ../index.php");
                    exit;
                default:
                    echo "Unknown role.";
                    break;
            }
        } else {
            // IF Password is incorrect
            $errorMsg = "Invalid password.";
        }
    } else {
        // IF User does not exist
        $errorMsg = "Invalid username.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/headerStyle.css">
    <link rel="stylesheet" href="../Styles/login.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Login - The Gallery Café</title>
</head>

<body>
    <!-- header section -->
    <div class="header">
        <nav>
            <div class="header-top">
                <div class="contact-info-header">
                    <span class="phone-number">
                        <img src="../Assets/icons/phone-call.png" alt="Phone" /> +941 122 5580
                    </span>
                </div>
                <img src="../Assets/logo.jpg" alt="The Gallery Café" class="logo" />
                <div class="header-right">
                    <a href="#" class="search">
                        <img src="../Assets/icons/search.png" alt="Search" />
                    </a>

                    <a href="../Pages/cart.html" class="cart">
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

    <!-- Login-Form -->
    <div class="main-container">
        <div class="login-container">
            <h1>Login to The Gallery Café</h1>
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="reg">
                <label>If you don't have an account:</label>
                <a href="register.php"><button type="button">Register</button></a>
            </div>
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

    <!-- Script for alert if the username or password is incorrect -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the error message from the PHP variable
            var errorMsg = "<?php echo $errorMsg; ?>";
            if (errorMsg) {
                alert(errorMsg);
            }
        });
    </script>
</body>

</html>