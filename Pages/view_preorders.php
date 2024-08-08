<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database configuration
include ("../db.php");

$username = $_SESSION['username'];

// Fetch user details
$sql = "SELECT * FROM users WHERE username = '$username'";
$userResult = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($userResult);

// Fetch pre-orders for the logged-in user
$sql = "SELECT * FROM pre_orders WHERE email = '" . $user['email'] . "' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/preorder.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>The Gallery Café - Preorders</title>
</head>
<body>
<?php include("../Components/header.php"); ?>

<div class="orders-container">
    <h1>Your Preorders</h1>
    <?php if (empty($orders)): ?>
        <p>You have no preorders.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order">
                <h2>Order #<?php echo htmlspecialchars($order['id']); ?></h2>
                <p>Date: <?php echo htmlspecialchars($order['created_at']); ?></p>
                <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                <h3>Order Details:</h3>
                <ul>
                    <?php foreach (json_decode($order['order_details'], true) as $item): ?>
                        <li>
                            <div class="item-container">
                                <span class="item-name"><?php echo htmlspecialchars($item['name']); ?> (x<?php echo htmlspecialchars($item['quantity']); ?>)</span>
                                <span class="item-total">Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include("../Components/footer.php"); ?>
</body>
</html>
