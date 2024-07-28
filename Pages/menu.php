<?php
session_start();
// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if a search query is set
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM cuisine_items";
if (!empty($searchQuery)) {
    $query .= " WHERE cuisine_type LIKE ?";
}

$stmt = $conn->prepare($query);

if (!empty($searchQuery)) {
    $searchParam = '%' . $searchQuery . '%';
    $stmt->bind_param("s", $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();
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
  <?php include ("../Components/header.php"); ?>

    <!-- search bar -->
    <div class="search-container">
        <form method="GET" action="menu.php">
            <input type="text" name="search" id="search-input" placeholder="Search by cuisine type (e.g., Sri Lankan, Chinese)" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <?php if (!empty($searchQuery)): ?>
           
    <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="search-item" data-cuisine="' . htmlspecialchars($row['cuisine_type']) . '">';
                        echo '<h2>' . htmlspecialchars($row['cuisine_type']) . '</h2>';
                        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>.....No cuisine-type found.....!</p>';
                }
                ?>
            </div>
        <?php endif; ?>

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
     
      <div class="cuisine-item" onclick="showCuisine('chinese')">
        <img src="../Assets/menu/chinese.jpg" alt="Chinese" />
        <h2>Chinese</h2>
      </div>
      <div class="cuisine-item" onclick="showCuisine('thai')">
        <img src="../Assets/menu/thai-food.jpg" alt="Thai" />
        <h2>Thai</h2>
      </div>
    
      <?php 
      $allCuisinesQuery = "SELECT * FROM cuisine_items";
      $allCuisinesResult = $conn->query($allCuisinesQuery);

      while ($cuisine = $allCuisinesResult->fetch_assoc()): ?>
        <div class="cuisine-item" onclick="showCuisine('<?php echo htmlspecialchars(strtolower($cuisine['cuisine_type'])); ?>')">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($cuisine['image']); ?>" alt="<?php echo htmlspecialchars($cuisine['cuisine_type']); ?>" />
          <h2><?php echo htmlspecialchars($cuisine['cuisine_type']); ?></h2>
        </div>
      <?php endwhile; ?>
    </div>  
    </div>

  <!-- footer-section -->
  <?php include ("../Components/footer.php"); ?>

  <script src="../Scripts/menu.js"></script>
</body>

</html>