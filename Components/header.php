<!-- header section -->
<div class="header" style="z-index:500 ;">
  <nav>
    <div class="header-top">

      <div class="header-right">

        <a href="../Pages/cart.php" class="cart">
          <img src="../Assets/icons/shopping-cart.png" alt="Cart" />
        </a>

        <?php if (!isset($_SESSION['role'])): ?>
          <a href="./login.php" class="register">
            <img src="../Assets/icons/register.png" alt="Login" />Login
          </a>
        <?php else: ?>
          <?php if ($_SESSION['role'] === 'customer'): ?>
            <a href="../Pages/customer_profile.php" class="register">
              <img src="../Assets/icons/register.png" alt="User" />
              <span> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
          <?php elseif ($_SESSION['role'] === 'staff'): ?>
            <a href="../Pages/staff.php" class="register">
              <img src="../Assets/icons/register.png" alt="User" />
              <span> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
          <?php elseif ($_SESSION['role'] === 'admin'): ?>
            <a href="../Pages/admin.php" class="register">
              <img src="../Assets/icons/register.png" alt="User" />
              <span> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
          <?php endif; ?>
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