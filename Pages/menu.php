<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Styles/headerStyle.css">
    <link rel="stylesheet" href="../Styles/menu.css" />
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <title>The Gallery Café - Menu</title>
  </head>
  <body>
  <!-- header section -->
  <?php include("../Components/header.php"); ?>

    <!-- menu-container -->
    <div class="menu-container">
      <h1>Our Menu</h1>

     
        <a href="./beverages.php" style="text-decoration: none;">
          <div id="beverages" class="menu-section">
            <h2>Beverages</h2>
          </div>
        </a>
      
        <!-- generate menu items here -->
      <div id="menu-items" class="menu-items"></div>
      

      <!-- cuisine items -->
      <div class="cuisine-grid">
        <div class="cuisine-item" onclick="showCuisine('italian')">
          <img src="../Assets/menu/italian.jpg" alt="Italian" />
          <h2>Italian</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('sushi')">
          <img src="../Assets/sushi.jpg" alt="Sushi" />
          <h2>Sushi</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('mexican')">
          <img src="../Assets/menu/mexican.jpg" alt="Mexican" />
          <h2>Mexican</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('french')">
          <img src="../Assets/menu/french.jpg" alt="French" />
          <h2>French</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('srilankan')">
          <img src="../Assets/menu/sri-lankan.jpg" alt="Sri Lankan" />
          <h2>Sri Lankan</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('indian')">
          <img src="../Assets/menu/indian.jpg" alt="Indian" />
          <h2>Indian</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('chinese')">
          <img src="../Assets/menu/chinese.jpg" alt="Chinese" />
          <h2>Chinese</h2>
        </div>
        <div class="cuisine-item" onclick="showCuisine('thai')">
          <img src="../Assets/menu/thai-food.jpg" alt="Thai" />
          <h2>Thai</h2>
        </div>
      </div>
      </div>

     <!-- footer-section -->
     <?php include("../Components/footer.php"); ?>
    
    <script src="../Scripts/menu.js"></script>
  </body>
</html>
