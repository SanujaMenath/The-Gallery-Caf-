<?php
session_start();

// Database config
include("../db.php");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query based on input type (email or username)
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email = ?";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
    }

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('MySQL prepare statement failed: ' . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 's', $username);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        // Check if password column matches
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect based on user role
            header("Location: ./index.php");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password.'); window.location.href = './login.php';</script>";
        }
    } else {
        // No user found
        echo "<script>alert('No user found with that username or email.'); window.location.href = './login.php';</script>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/login.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Login - The Gallery Café</title>
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

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