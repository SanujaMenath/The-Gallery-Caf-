<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

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

$username = $_SESSION['username'];

// Fetch cart items for the logged-in user
$sql = "SELECT cart.id, beverages.name, beverages.price_regular, beverages.price_large, cart.quantity
        FROM cart
        JOIN beverages ON cart.beverage_id = beverages.id
        WHERE cart.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/headerStyle.css">
  <link rel="stylesheet" href="../Styles/cart.css">
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>The Gallery Café - Cart</title>
</head>
<body>

<?php include("../Components/header.php"); ?>

  <!-- Display cart-container -->
  <div class="cart-container">
        <h1>Your Cart</h1>
        <ul class="cart-items">
            <?php if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cartItems as $item): ?>
                    <li class="cart-item">
                        <div class="cart-item-details">
                            <h2><?php echo $item['name']; ?></h2>
                            <p>Price: Rs.<?php echo $item['price_regular']; ?></p>
                            <p>Quantity: <input class="cart-item-quantity" type="number" value="<?php echo $item['quantity']; ?>" min="1"></p>
                        </div>
                        <div class="cart-item-actions">
                            <form action="../Pages/remove_from_cart.php" method="POST">
                                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                <button class="remove-button" type="submit">Remove</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <div class="cart-summary">
            <h2>Cart Summary</h2>
            <p>Total Items: <?php echo count($cartItems); ?></p>
            <!-- Calculate and display the total price -->
            <?php 
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['price_regular'] * $item['quantity'];
            }
            ?>
            <p>Total Price: Rs.<?php echo number_format($total, 2); ?></p>
            <button class="checkout-button">Proceed to Checkout</button>
        </div>
    </div>

  <!-- footer-section -->
  <footer>
    <div class="footer-container">
      <div class="footer-section about">
        <h2>The Gallery Café</h2>
        <p>
          Welcome to The Gallery Café, where we blend the love for art and food. Enjoy our carefully curated menu and the artistic ambiance.
        </p>
      </div>
      <div class="footer-section links">
        <h2>Quick Links</h2>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="./menu.php">Menu</a></li>
          <li><a href="./reservation.php">Reservations</a></li>
          <li><a href="./aboutUs.php">About Us</a></li>
          <li><a href="./contact.php">Contact</a></li>
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
