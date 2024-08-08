<?php
session_start();

// Database configuration
include ("./db.php");

// Fetch all promotions
$promotions_sql = "SELECT * FROM promotions";
$promotions_result = mysqli_query($conn, $promotions_sql);

if (!$promotions_result) {
  die("Error fetching promotions: " . mysqli_error($conn));
}

// Fetch featured menu items
$featured_items_query = "
    SELECT name, description, image 
    FROM menu_item 
    WHERE is_featured = 1";
$featured_items_result = mysqli_query($conn, $featured_items_query);

if (!$featured_items_result) {
  die("Error fetching featured items: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./Styles/footer.css">
  <link rel="stylesheet" href="./styles/header.css">
  <link rel="stylesheet" href="./styles/carousel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./Styles/index.css" />
  <title>The Gallery Café</title>
</head>

<body>
  <header>
    <!-- header section -->
    <div class="header" style="z-index: 5000;">
      <nav>
        <div class="header-top">
          <div class="header-right">
            <a href="./Pages/cart.php" class="cart">
              <img src="./Assets/icons/shopping-cart.png" alt="Cart" />
            </a>

            <?php if (!isset($_SESSION['role'])): ?>
              <a href="./Pages/login.php" class="register">
                <img src="./Assets/icons/register.png" alt="Login" />Login
              </a>
            <?php else: ?>
              <a href="./Pages/customer_profile.php" class="register">
                <img src="./Assets/icons/register.png" alt="User" />
                <?php echo htmlspecialchars($_SESSION['username']); ?>
              </a>
            <?php endif; ?>


          </div>
        </div>
        <ul class="nav-links">
          <li><a href="./index.php">Home</a></li>
          <li><a href="./Pages/menu.php">Menu</a></li>
          <li><a href="./Pages/reservation.php">Reservations</a></li>

          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><a href="./Pages/admin.php">Dashboard</a></li>

          <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>
            <li><a href="./Pages/staff.php">Dashboard</a></li>
          <?php endif; ?>

          <li><a href="./Pages/aboutUs.php">About Us</a></li>
          <li><a href="./Pages/contact.php">Contact</a></li>
        </ul>
      </nav>
    </div>

    <!-- Hero Section -->
    <section class="hero">
      <div class="text-container">
        <div class="boder">
          <h1>The Gallery Café</h1>
          <img src="./Assets/icons/logo.png" alt="">
          <p>Where art meets food. Enjoy a delightful experience.</p>
          <a href="./Pages/reservation.php" class="btn">Make a Reservation</a>
        </div>
      </div>
    </section>
  </header>

  <!-- carousel-section -->
  <section class="carouselContainer">
    <div id="controls" class="controls">
      <button id="left" style="padding: 10px; font-size: 40px;">
        < </button>
          <button id="right" style="padding: 10px; font-size: 40px;">
            >
          </button>
      </div>
      <div id="carousel">

      </div>


  </section>

  <!-- Introduction/About Section -->
  <section class="feature-about">
    <div class="feature-box">
      <div class="feature-icon">
        <img src="./Assets/icons/healthcare.png" alt="Icon 1" />
      </div>

      <h3>TOUCHING HEARTS SINCE 1998</h3>
      <p>
        Satisfying the taste buds of sri lankan customers since 1998 have grown into a huge variety of cuisines to
        extend our loyalty back towards our customers.
      </p>

    </div>
    <div class="feature-box">
      <div class="feature-icon">
        <img src="./Assets/icons/dinner-date.png" alt="Icon 2" />
      </div>
      <h3>EXCEPTIONAL DINING EXPERIENCE</h3>
      <p>
        At The Gallery Café, the satisfaction of our guests is our highest priority. We ensure a memorable dining
        experience with top-notch service, exquisite cuisine, and a comfortable atmosphere, all while adhering to the
        highest standards of hygiene and safety.
      </p>

    </div>
    <div class="feature-box">
      <div class="feature-icon">
        <img src="./Assets/icons/dining.png" alt="Icon 3" />
      </div>
      <h3>Café CLEANSTAY</h3>
      <p>
        At The Gallery Café, we blend the love for art and food. Enjoy our
        carefully curated menu and the artistic ambiance. Our café is a
        perfect place for art enthusiasts and food lovers to relax and enjoy.
      </p>
    </div>
  </section>


  <!-- Promotions and Events Section -->
  <section class="promotions-events">
    <h2>Special Promotions & Events</h2>
    <div class="promotions-events-container">
      <?php while ($promotion = mysqli_fetch_assoc($promotions_result)) { ?>
        <div class="event">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>"
            alt="<?php echo htmlspecialchars($promotion['name']); ?>" />
          <div class="event-details">
            <h3><?php echo htmlspecialchars($promotion['name']); ?></h3>
            <p><?php echo htmlspecialchars($promotion['description']); ?></p>
            <button class="btn">Learn More</button>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- <div class="event">

          <h3>Art Exhibition</h3>
          
            Explore our latest art exhibition while enjoying a curated menu. A
            perfect evening for art enthusiasts and food lovers. -->


  <!-- Featured Menu Items Section -->
  <section class="featured-menu">
    <h2>Featured Menu Items</h2>
    <div class="menu-grid">

      <?php while ($item = mysqli_fetch_assoc($featured_items_result)): ?>

        <div class="menu-item">
          <?php if (!empty($item['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>"
              alt="<?php echo htmlspecialchars($item['name']); ?>" />
          <?php endif; ?>

          <h3><?php echo htmlspecialchars($item['name']); ?></h3>
          <p><?php echo htmlspecialchars($item['description']); ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery">
    <h2>Our Gallery</h2>
    <div class="gallery-grid">
      <img src="./Assets/coffee-shop4.jpg" alt="Gallery Image 1" />
      <img src="./Assets/coffee-shop-dark.jpg" alt="Gallery Image 2" />
      <img src="./Assets/coffee.jpg" alt="Gallery Image 3" />
      <img src="./Assets/coffee-shop2.jpg" alt="Gallery Image 4" />
    </div>
    <div class="load-more">
      <span class="arrow">▼</span>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial-grid">
      <div class="testimonial-item">
        <p>
          "Amazing atmosphere and delicious food. A perfect place to unwind
          and enjoy art!"
        </p>
        <h3>- John Doe</h3>
      </div>
      <div class="testimonial-item">
        <p>
          "The Gallery Café offers a unique dining experience with its
          artistic décor and exquisite dishes."
        </p>
        <h3>- Jane Smith</h3>
      </div>
      <div class="testimonial-item">
        <p>
          "I love the blend of art and food here. The sushi platter is my
          favorite."
        </p>
        <h3>- Sarah Lee</h3>
      </div>
    </div>
  </section>

  <!-- Newsletter Signup Section -->
  <section class="newsletter">
    <h2>Stay Updated</h2>
    <p>
      Subscribe to our newsletter to receive the latest news and special
      offers.
    </p>
    <form action="#">
      <input type="email" placeholder="Enter your email" required />
      <button type="submit">Subscribe</button>
    </form>
  </section>

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
          <li><a href="./Pages/menu.php">Menu</a></li>
          <li><a href="./Pages/reservation.php">Reservations</a></li>
          <li><a href="./Pages/aboutUs.php">About Us</a></li>
          <li><a href="./Pages/contact.php">Contact</a></li>
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


  <script src="./Scripts/index.js"></script>
</body>

</html>