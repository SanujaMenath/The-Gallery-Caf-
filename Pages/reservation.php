<?php
session_start();
// Database configuration
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $people = $conn->real_escape_string($_POST['people']);
    $requests = $conn->real_escape_string($_POST['requests']);

    // SQL query to insert reservation
    $sql = "INSERT INTO reservations (name, email, phone, date, time, people, requests)
            VALUES ('$name', '$email', '$phone', '$date', '$time', '$people', '$requests')";

    if ($conn->query($sql) === TRUE) {
        $message = "Reservation made successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/headerStyle.css">
    <link rel="stylesheet" href="../Styles/reservation.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <title>The Gallery Café - Reservations</title>
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
            <a href="../Pages/login.html" class="register">
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
        <li><a href="./reservation.html">Reservations</a></li>

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

    <!-- reservation-section -->
    <div class="reservation-container">
        <h1>Reserve a Table</h1>
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form class="reservation-form" action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="people">Number of People:</label>
            <input type="number" id="people" name="people" min="1" required>

            <label for="requests">Special Requests:</label>
            <textarea id="requests" name="requests"></textarea>

            <button type="submit">Reserve Now</button>
        </form>
    </div>

    <!-- footer-section -->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>The Gallery Café</h2>
                <p>Welcome to The Gallery Café, where we blend the love for art and food. Enjoy our carefully curated menu and the artistic ambiance.</p>
            </div>
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="./index.html">Home</a></li>
                    <li><a href="./Pages/menu.html">Menu</a></li>
                    <li><a href="./Pages/reservation.html">Reservations</a></li>
                    <li><a href="./Pages/aboutUs.html">About Us</a></li>
                    <li><a href="./Pages/contact.html">Contact</a></li>
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
