<!-- Header Section -->
<div class="header" style="z-index: 5000;">
   <nav>
     <div class="header-top">
       <div class="header-right">
        
         <!-- Cart Icon and Link -->
         <a href="./cart.php" class="cart">
           <img src="../Assets/icons/shopping-cart.png" alt="Cart" />
         </a>

         <!-- User Login/Profile Section -->
         <?php if (!isset($_SESSION['role'])): ?>

           <a href="./login.php" class="register">
             <img src="../Assets/icons/register.png" alt="Login" />Login
           </a>
         <?php else: ?>

           <!-- If the user is logged in -->
           <?php if ($_SESSION['role'] === 'customer'): ?>
             <!-- If the user is a customer, show the profile link -->
             <a href="./customer_profile.php" class="register">
               <img src="../Assets/icons/register.png" alt="User" />
               <?php echo htmlspecialchars($_SESSION['username']); ?>
             </a>
           <?php else: ?>

             <!-- For non-customers  -->
             <span class="register">
               <img src="../Assets/icons/register.png" alt="User" />
               <?php echo htmlspecialchars($_SESSION['username']); ?>
             </span>
           <?php endif; ?>
         <?php endif; ?>
       </div>
     </div>

     <!-- Navigation Links -->
     <ul class="nav-links">
       
       <li><a href="./index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>

      
       <li><a href="./menu.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?>">Menu</a></li>

       <li><a href="./reservation.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'reservation.php' ? 'active' : ''; ?>">Reservations</a></li>

      
       <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

         <!-- If the user is an admin, show the Admin Dashboard link -->
         <li><a href="./admin.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : ''; ?>">Dashboard</a></li>
       <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>

         <!-- show the Staff Dashboard link -->
         <li><a href="./staff.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'staff.php' ? 'active' : ''; ?>">Dashboard</a></li>
       <?php endif; ?>

       <li><a href="./aboutUs.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'aboutUs.php' ? 'active' : ''; ?>">About Us</a></li>

       <li><a href="./contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
     </ul>
   </nav>
</div>
