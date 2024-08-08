<?php
session_start();
include("../db.php");

// Check if a cuisine_item ID is provided
if (isset($_GET['cuisine_item'])) {
    $cuisine_item_id = intval($_GET['cuisine_item']);
    $menu_items_query = "SELECT * FROM menu_item WHERE cuisine_item = $cuisine_item_id";
} else {
    // If no cuisine_item ID is provided, fetch all menu items
    $menu_items_query = "SELECT * FROM menu_item";
}

$menu_items_result = mysqli_query($conn, $menu_items_query);

if (!$menu_items_result) {
    die("Error fetching menu items: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/footer.css" /> 
    <link rel="stylesheet" href="../styles/view_menu_items.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header section -->
    <?php include("../Components/header.php"); ?>

    <!-- Menu items display -->
    <div class="menu-container">
        <?php while ($item = mysqli_fetch_assoc($menu_items_result)): ?>
            <div class="menu-item">
                <?php if (!empty($item['image'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <?php else: ?>
                    <img src="../Images/default_image.jpg" alt="No image available">
                <?php endif; ?>
                <div class="menu-item-content">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p class="price">RS. <?php echo htmlspecialchars($item['price']); ?></p>
                    <form method="POST" action="add_to_cart.php" class="qtysubmit">
                        <input type="hidden" name="menu_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <div class="quantity-selector">
                            <button type="button" onclick="updateQuantity('menu-<?php echo $item['id']; ?>', false)">-</button>
                            <input type="number" id="menu-<?php echo $item['id']; ?>" name="quantity" value="1" min="1" readonly>
                            <button type="button" onclick="updateQuantity('menu-<?php echo $item['id']; ?>', true)">+</button>
                        </div>
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Footer section -->
    <?php include("../Components/footer.php"); ?>

    <script>
        function updateQuantity(id, increment) {
            var quantityInput = document.getElementById(id);
            var currentQuantity = parseInt(quantityInput.value);
            if (increment) {
                quantityInput.value = currentQuantity + 1;
            } else {
                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                }
            }
        }
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
