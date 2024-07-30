<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu</title>
  <link rel="stylesheet" href="../Styles/header.css">
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="../Styles/beverages.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <!-- header section -->
  <?php include ("../components/header.php"); ?>

  <!-- beverages-section -->
  <div class="beverages-menu">
    <h1>Beverages Menu</h1>
    <ul class="beverage-list">
      <?php
      // Database configuration
      include ("../db.php");

      // Fetch beverages data
      $sql = "SELECT id, name, image, price_regular, price_large FROM beverages";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
          echo "<li>";
          echo "<span class='beverage-name'>" . htmlspecialchars($row['name']) . "</span>";
          echo "<span class='price'>Regular: LKR " . htmlspecialchars($row['price_regular']) . " | Large: LKR " . htmlspecialchars($row['price_large']) . "</span>";
          if (!empty($row['add_ons'])) {
            echo "<span class='addons'>Image: " . htmlspecialchars($row['image']) . " </span>";
          }
          echo "<form method='POST' action='add_to_cart.php'>";
          echo "<input type='hidden' name='beverage_id' value='" . htmlspecialchars($row['id']) . "'>";
          echo "<button type='submit' class='add-to-cart'>Add to Cart</button>";
          echo "</form>";
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
  <?php include ("../Components/footer.php"); ?>

</body>

</html>