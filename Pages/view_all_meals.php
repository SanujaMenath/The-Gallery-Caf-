<?php
session_start();

// Database config
include("../db.php");

// Initialize search query
$searchName = isset($_GET['search_name']) ? mysqli_real_escape_string($conn, $_GET['search_name']) : '';
$searchCuisine = isset($_GET['search_cuisine']) ? mysqli_real_escape_string($conn, $_GET['search_cuisine']) : '';

// Fetch cuisine types from the database
$cuisineQuery = "SELECT id, cuisine_type FROM cuisine_items";
$cuisineResult = mysqli_query($conn, $cuisineQuery);

if (!$cuisineResult) {
    die("Error fetching cuisine types: " . mysqli_error($conn));
}

// Construct the SQL query with search parameters
$sql = "SELECT menu_item.id, menu_item.name, menu_item.description, menu_item.price, menu_item.image, cuisine_items.cuisine_type 
        FROM menu_item 
        INNER JOIN cuisine_items ON menu_item.cuisine_item = cuisine_items.id
        WHERE 1";

if (!empty($searchName)) {
    $sql .= " AND menu_item.name LIKE '%$searchName%'";
}

if (!empty($searchCuisine)) {
    $sql .= " AND cuisine_items.cuisine_type = '$searchCuisine'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching menu items: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/menu.css" />
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Menu Items</title>
</head>

<body>
    <!-- Header section -->
    <?php include("../Components/header.php"); ?>

    <!-- Search bar -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search_name" id="search-name-input" placeholder="Search by menu item name" value="<?php echo isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : ''; ?>">
            <select name="search_cuisine" id="search-cuisine-input">
                <option value="" selected disabled>Select cuisine type</option>
                <?php while ($cuisine = mysqli_fetch_assoc($cuisineResult)): ?>
                    <option value="<?php echo htmlspecialchars($cuisine['cuisine_type']); ?>" <?php echo (isset($_GET['search_cuisine']) && $_GET['search_cuisine'] == $cuisine['cuisine_type']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cuisine['cuisine_type']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Search results -->
    <?php if (!empty($searchName) || !empty($searchCuisine)): ?>
        <div class="search-results">
            <?php
            if ($result->num_rows > 0) {
                while ($meals = mysqli_fetch_assoc($result)) {
                    echo '<div class="search-item" data-cuisine="' . htmlspecialchars($meals['cuisine_type']) . '">';
                    echo '<a href="view_menu_items.php?menu_item=' . urlencode($meals['id']) . '">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($meals['image']) . '" alt="' . htmlspecialchars($meals['name']) . '" />';
                    echo '<h2>' . htmlspecialchars($meals['name']) . '</h2>';
                    echo '<p>' . htmlspecialchars($meals['cuisine_type']) . '</p>';
                    echo '<p>$' . htmlspecialchars($meals['price']) . '</p>';
                    echo '<p>' . htmlspecialchars($meals['description']) . '</p>';
                    echo '</a></div>';
                }
            } else {
                echo '<p>No matching items found!</p>';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="menu-container">
        <!-- Display All Menu Items -->
        <div class="cuisine-grid">
            <?php
            // Reset result pointer and display all menu items if no search criteria
            if (empty($searchName) && empty($searchCuisine)) {
                mysqli_data_seek($result, 0);
                while ($meals = mysqli_fetch_assoc($result)): ?>
                    <div class="cuisine-item">
                        <a href="view_menu_items.php?menu_item=<?php echo urlencode($meals['id']); ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($meals['image']); ?>" alt="<?php echo htmlspecialchars($meals['name']); ?>" />
                            <h2><?php echo htmlspecialchars($meals['name']); ?></h2>
                        </a>
                    </div>
                <?php endwhile;
            }
            ?>
        </div>
    </div>

    <!-- Footer section -->
    <?php include("../Components/footer.php"); ?>

</body>

</html>
