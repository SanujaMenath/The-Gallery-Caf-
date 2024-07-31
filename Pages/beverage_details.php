<?php
session_start();

// Database configuration
include ("../db.php");

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $beverage_id = intval($_GET['id']);

    // Fetch beverage details including description
    $sql = "SELECT id, name, image, description, price_regular, price_large FROM beverages WHERE id = $beverage_id";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful and if there is a result
    if ($result && mysqli_num_rows($result) > 0) {
        $beverage = mysqli_fetch_assoc($result);
    } else {
        echo "No beverage found.";
        exit;
    }
} else {
    echo "No beverage selected.";
    exit;
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($beverage['name']); ?> - Beverage Details</title>
    <link rel="stylesheet" href="../styles/beverage_details.css">
    <script>
        function updateQuantity(increment) {
            var quantityInput = document.getElementById("quantity");
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
</head>

<body>
    <div class="beverage-grid">
        <div class="beverage-details ">
        <?php if (!empty($beverage['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($beverage['image']); ?>"
                alt="<?php echo htmlspecialchars($beverage['name']); ?>" class="beverage-image">
        <?php endif; ?>
        </div>

        <div class="beverage-details ">
        <h1><?php echo htmlspecialchars($beverage['name']); ?></h1>

        <span class="price">Regular: LKR <?php echo htmlspecialchars($beverage['price_regular']); ?> | Large: LKR
        <?php echo htmlspecialchars($beverage['price_large']); ?></span>

        <p class="description"><?php echo htmlspecialchars($beverage['description']); ?></p>      

        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="beverage_id" value="<?php echo htmlspecialchars($beverage['id']); ?>">
            <div class="quantity-selector">
                <button type="button" onclick="updateQuantity(false)">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                <button type="button" onclick="updateQuantity(true)">+</button>
            </div>
            <button type="submit" class="add-to-cart">Add to Cart</button>
        </form>
        </div>
    </div>
</body>

</html>