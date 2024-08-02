<?php
session_start();

// Database configuration
include("../db.php");

$sql = "SELECT * FROM cuisine_items";
$result = mysqli_query($conn,$sql);

if(!$result){
  die("Error fetching menu items: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/header.css">
  <link rel="stylesheet" href="../Styles/menu.css" />
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>The Gallery Café - Menu</title>
</head>

<body>
  <!-- Header section -->
  <?php include ("../Components/header.php"); ?>



  <!-- Menu container -->
  <div class="menu-container">
    <h1>Our Menu</h1>

    <a href="./beverages.php" style="text-decoration: none;">
      <div id="beverages" class="menu-section">
        <h2>Beverages</h2>
      </div>
    </a>

    <a href="./view_all_meals.php" style="text-decoration: none;">
      <div id="menu_items" class="menu-section">
        <h2>Menu Items</h2>
      </div>
    </a>

    <!-- Cuisine items -->
    <div class="cuisine-grid">
      <?php 
     
      while ($cuisine =  mysqli_fetch_assoc($result)): ?>
        <div class="cuisine-item">
          <a href="view_menu_items.php?cuisine_item=<?php echo urlencode($cuisine['id']); ?>"> 
            <img src="data:image/jpeg;base64,<?php echo base64_encode($cuisine['image']); ?>" alt="<?php echo htmlspecialchars($cuisine['cuisine_type']); ?>" />
            <h2><?php echo htmlspecialchars($cuisine['cuisine_type']); ?></h2>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Footer section -->
  <?php include ("../Components/footer.php"); ?>
</body>

</html>

<?php
mysqli_close($conn);
?>
