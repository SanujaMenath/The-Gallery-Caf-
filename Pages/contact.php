<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/headerStyle.css" />
  <link rel="stylesheet" href="../Styles/contact.css" />
  <link rel="stylesheet" href="../Styles/footer.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>The Gallery Café - Contact Us</title>
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

  <!-- contact-section -->
  <div class="contact-container">
    <h1>Contact Us</h1>
    <div class="contact-content">
      <div class="contact-info">
        <h2>Contact Information</h2>
        <p>
          <strong>Address:</strong> 123 Coffee Street, Mocha City, CA 90210
        </p>
        <p><strong>Phone:</strong> (123) 456-7890</p>
        <p><strong>Email:</strong> info@thegallerycafe.com</p>
      </div>
      <div class="contact-form">
        <h2>Send Us a Message</h2>
        <form action="send_message.php" method="post">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required />

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />

          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" required />

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send Message</button>
        </form>
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
</body>

</html>