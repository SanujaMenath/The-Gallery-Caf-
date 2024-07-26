<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu</title>
  <link rel="stylesheet" href="../Styles/headerStyle.css">
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="../Styles/beverages.css" />
</head>
<body>
  <!-- header section -->
  <div class="header">
    <nav>
      <div class="header-top">
        <div class="contact-info-header">
          <span class="phone-number">
            <img src="../Assets/icons/phone-call.png" alt="Search" />
            +941 122 5580
          </span>
        </div>
        <img src="../Assets/logo.jpg" alt="The Gallery Café" class="logo" />
        <div class="header-right">
          <a href="#" class="search">
            <img src="../Assets/icons/search.png" alt="Search" />
          </a>

          <a href="./Pages/cart.html" class="cart">
            <img src="../Assets/icons/shopping-cart.png" alt="Cart" />
          </a>

          <?php if (!isset($_SESSION['role'])): ?>
            <a href="./login.html" class="register">
              <img src="../Assets/icons/register.png" alt="Login" />Login
            </a>
          <?php else: ?>
            <a href="./Pages/user.html" class="register">
              <img src="../Assets/icons/register.png" alt="User" />
              <?php echo htmlspecialchars($_SESSION['username']); ?>
            </a>
          <?php endif; ?>

          <?php if (isset($_SESSION['role'])): ?>
            <a href="./logout.php" class="register">
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

  <!-- beverages-section -->
  <div class="beverages-menu">
    <h1>Beverages Menu</h1>
    <ul class="beverage-list">
      <?php
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

      // Fetch beverages data
      $sql = "SELECT name, add_ons, price_regular, price_large, price_add_ons FROM beverages";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
          echo "<li>";
          echo "<span class='beverage-name'>" . htmlspecialchars($row['name']) . "</span>";
          echo "<span class='price'>Regular: LKR " . htmlspecialchars($row['price_regular']) . " | Large: LKR " . htmlspecialchars($row['price_large']) . "</span>";
          if (!empty($row['add_ons'])) {
              echo "<span class='addons'>Add-ons: " . htmlspecialchars($row['add_ons']) . " (+" . htmlspecialchars($row['price_add_ons']) . " LKR)</span>";
          }
          echo "</li>";
      }      
      } else {
        echo "<li>No beverages available</li>";
      }
      $conn->close();
      ?>
    </ul>
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
