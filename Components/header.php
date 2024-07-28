 <!-- header section -->
 <div class="header">
    <nav>
      <div class="header-top">
        <div class="contact-info-header">
          <span class="phone-number">
            <img src="../Assets/icons/phone-call.png" alt="Search">
            +941 122 5580
          </span>
        </div>
        <img src="../Assets/logo.jpg" alt="The Gallery Café" class="logo">
        <div class="header-right">
          <a href="#" class="search">
            <img src="../Assets/icons/search.png" alt="Search">
          </a>
          <a href="./cart.php" class="cart">
            <img src="../Assets/icons/shopping-cart.png" alt="Cart">
          </a>
          <?php if (!isset($_SESSION['role'])): ?>
            <a href="./login.php" class="register">
              <img src="../Assets/icons/register.png" alt="Login">Login
            </a>
          <?php else: ?>
            <a href="#" class="register">
              <img src="../Assets/icons/register.png" alt="User">
              <?php echo htmlspecialchars($_SESSION['username']); ?>
            </a>
          <?php endif; ?>
          <?php if (isset($_SESSION['role'])): ?>
            <a href="./logout.php" class="register">Logout</a>
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