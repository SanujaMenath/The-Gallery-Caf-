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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./Styles/index.css" />
  <title>The Gallery Café</title>
</head>

<body>
  <header>
    <!-- header section -->
    <div class="header">
      <nav>
        <div class="header-top">
          <!-- <img src="./Assets/logo.jpg" alt="The Gallery Café" class="logo" /> -->
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

            <?php if (isset($_SESSION['role'])): ?>
              <a href="./Pages/logout.php" class="register">
                Logout
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
    <p>Where art meets food. Enjoy a delightful experience.</p>
    <a href="./Pages/reservation.php" class="btn">Make a Reservation</a>
      </div></div>
    </section>
  </header>

  <!-- carousel-section -->
  <section class="carousel">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
          aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./Assets/coffee-shop.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h3>Welcome to Our Café</h3>
            <p>Experience the best coffee in town.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./Assets/coffee-shop2.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h3>Delicious Treats</h3>
            <p>Enjoy a variety of freshly baked goods.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./Assets/coffee-shop3.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h3>Cozy Ambiance</h3>
            <p>Relax in our cozy and artistic atmosphere.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script src="./Scripts/index.js"></script>
</body>

</html>