<?php
session_start();

// Database configuration
include("../db.php");

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $beverage_id = intval($_GET['id']);

    // Fetch beverage details
    $sql = "SELECT id, name, image, price_regular, price_large FROM beverages WHERE id = $beverage_id";
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

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($beverage['name']); ?> - Beverage Details</title>
    <link rel="stylesheet" href="../styles/beverage_details.css">
</head>
<body>
    <div class="beverage-details">
        <h1><?php echo htmlspecialchars($beverage['name']); ?></h1>
        <?php if (!empty($beverage['image'])): ?>
            <img src="<?php echo htmlspecialchars($beverage['image']); ?>" alt="<?php echo htmlspecialchars($beverage['name']); ?>" class="beverage-image">
        <?php endif; ?>
        <span class="price">Regular: LKR <?php echo htmlspecialchars($beverage['price_regular']); ?> | Large: LKR <?php echo htmlspecialchars($beverage['price_large']); ?></span>
        
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="beverage_id" value="<?php echo htmlspecialchars($beverage['id']); ?>">
            <button type="submit" class="add-to-cart">Add to Cart</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
