<?php
session_start();

// Database configuration
include ("../db.php");

// Fetch beverages data
$sql = "SELECT id, name, image FROM beverages";
$result = mysqli_query($conn, $sql);
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
    <div class="beverage-grid">
      <?php
        // Output data of each row
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='beverage-item' onclick=\"window.location.href='beverage_details.php?id=" . htmlspecialchars($row['id']) . "'\">";
              if (!empty($row['image'])) {
                  $imageData = base64_encode($row['image']);
                  echo "<img src='data:image/jpeg;base64," . $imageData . "' alt='" . htmlspecialchars($row['name']) . "' class='beverage-image'>";
              }
              echo "<h2 class='beverage-name'>" . htmlspecialchars($row['name']) . "</h2>";
              echo "</div>";
          }
      } else {
          echo "<div>No beverages available</div>";
      }
      $conn->close();
      ?>
    </div>
  </div>

  <!-- footer-section -->
  <?php include ("../Components/footer.php"); ?>

</body>
</html>
