<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="../Styles/headerStyle.css" />
  <link rel="stylesheet" href="../Styles/footer.css" />
  <link rel="stylesheet" href="../Styles/aboutUs.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <a href="./login.php" class="register">
              <img src="../Assets/icons/register.png" alt="Login" />Login
            </a>
          <?php else: ?>
            <a href="" class="register">
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

  <!-- About Section -->
  <div class="about-container">
    <h1>About Us</h1>
    <section class="mission">
      <h2>Our Mission</h2>
      <p>
        At The Gallery Café, our mission is to provide a warm, inviting
        atmosphere where customers can enjoy delicious food, great coffee, and
        artistic surroundings. We believe in the power of community and aim to
        create a space where everyone feels welcome.
      </p>
    </section>
    <section class="team">
      <h2>Meet Our Team</h2>
      <div class="team-member">
        <img src="../Assets/about/ceo.jpg" alt="Jane Doe" />
        <h3>Jane Doe</h3>
        <p>Founder & CEO</p>
        <p>
          Jane is the visionary behind The Gallery Café. With a background in
          art and culinary arts, she has combined her passions to create a
          unique café experience.
        </p>
      </div>
      <div class="team-member">
        <img src="../Assets/about/chef.jpg" alt="John Smith" />
        <h3>John Smith</h3>
        <p>Head Chef</p>
        <p>
          John is the culinary genius in our kitchen. His innovative dishes
          and commitment to using fresh, local ingredients make every meal
          unforgettable.
        </p>
      </div>
      <div class="team-member">
        <img src="../Assets/about/manager.jpg" alt="Sarah Brown" />
        <h3>Sarah Brown</h3>
        <p>Manager</p>
        <p>
          Sarah ensures that everything runs smoothly at The Gallery Café.
          With her extensive experience in hospitality, she guarantees
          excellent service for every customer.
        </p>
      </div>
    </section>
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
          <li><a href="./index.php">Home</a></li>
          <li><a href="./Pages/menu.html">Menu</a></li>
          <li><a href="./Pages/reservation.html">Reservations</a></li>
          <li><a href="./Pages/aboutUs.php">About Us</a></li>
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