<?php
session_start();
// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['role'])) {
        header("Location: ./login.html");
        exit();
    }
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $people = mysqli_real_escape_string($conn, $_POST['people']);
    $requests = mysqli_real_escape_string($conn, $_POST['requests']);

    // SQL query to insert reservation
    $sql = "INSERT INTO reservations (name, email, phone, date, time, people, requests)
            VALUES ('$name', '$email', '$phone', '$date', '$time', '$people', '$requests')";

    if (mysqli_query($conn, $sql)) {
      // If insertion is successful, show success message and redirect to login page
      echo "<script>alert('Reservation made successfully!'); window.location.href = './reservation.php';</script>";
  } else {
      // If insertion fails, show error message and redirect to registration page
      echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = './reservation.php';</script>";
  }

    mysqli_close($conn);
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/reservation.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>The Gallery Café - Reservations</title>
</head>
<body>
   <!-- header section -->
   <?php include ("../Components/header.php"); ?>

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