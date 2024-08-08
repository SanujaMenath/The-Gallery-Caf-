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

// Fetch cart items for the logged-in user
$sql = "SELECT cart.id, beverages.name AS beverage_name, beverages.price_regular, menu_item.name AS menu_name, menu_item.price AS menu_price, cart.quantity, cart.beverage_id, cart.menu_id
        FROM cart
        LEFT JOIN beverages ON cart.beverage_id = beverages.id
        LEFT JOIN menu_item ON cart.menu_id = menu_item.id
        WHERE cart.username = '$username'";
$result = mysqli_query($conn, $sql);

$cartItems = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkout'])) {
        // Update cart quantities
        if (isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $cart_id => $quantity) {
                $cart_id = mysqli_real_escape_string($conn, $cart_id);
                $quantity = mysqli_real_escape_string($conn, $quantity);
                $sql = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND username = '$username'";
                if (!mysqli_query($conn, $sql)) {
                    echo "<script>alert('Failed to update cart quantities.'); window.location.href = 'cart.php';</script>";
                    exit();
                }
            }
        }

        // Prepare order details
        $orderDetails = [];
        foreach ($cartItems as $item) {
            $orderDetails[] = [
                'name' => $item['beverage_name'] ? $item['beverage_name'] : $item['menu_name'],
                'price' => $item['beverage_name'] ? $item['price_regular'] : $item['menu_price'],
                'quantity' => $item['quantity']
            ];
        }
        $orderDetailsJson = json_encode($orderDetails);

        // Insert order into pre_orders table
        $name = mysqli_real_escape_string($conn, $user['first_name']);
        $email = mysqli_real_escape_string($conn, $user['email']);
        $phone = mysqli_real_escape_string($conn, $user['phone']);
        $sql = "INSERT INTO pre_orders (name, email, phone, order_details, status, created_at) VALUES ('$name', '$email', '$phone', '$orderDetailsJson', 'pending', NOW())";

        if (mysqli_query($conn, $sql)) {
            // Clear the cart
            $sql = "DELETE FROM cart WHERE username = '$username'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Order placed successfully!'); window.location.href = 'cart.php';</script>";
            } else {
                echo "<script>alert('Failed to clear the cart.'); window.location.href = 'cart.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to place order. Please try again.'); window.location.href = 'cart.php';</script>";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/cart.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>The Gallery Café - Checkout</title>
</head>

<body>
    <?php include ("../Components/header.php"); ?>

    <div class="cart-container">
        <h1>Checkout</h1>
        <form method="POST" action="">
            <ul class="cart-items">
                <?php if (empty($cartItems)): ?>
                    <p>Your cart is empty.</p>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <li class="cart-item">
                            <div class="cart-item-details">
                                <h2><?php echo htmlspecialchars($item['beverage_name'] ? $item['beverage_name'] : $item['menu_name']); ?></h2>
                                <p class="item-price">
                                    Rs. <?php echo htmlspecialchars($item['beverage_name'] ? $item['price_regular'] : $item['menu_price']); ?>
                                </p>
                                <p>Quantity: 
                                    <input type="number" class="item-quantity" name="quantity[<?php echo htmlspecialchars($item['id']); ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                </p>
                                <button type="button" class="remove-button" data-item-id="<?php echo htmlspecialchars($item['id']); ?>">Remove</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <div class="cart-summary">
                <h2>Cart Summary</h2>
                <p>Total Items: <?php echo count($cartItems); ?></p>
                <p>Total Price: Rs.<span class="total-price">
                        <?php
                        $total = 0;
                        foreach ($cartItems as $item) {
                            $price = $item['beverage_name'] ? $item['price_regular'] : $item['menu_price'];
                            $total += $price * $item['quantity'];
                        }
                        echo number_format($total, 2);
                        ?>
                    </span>
                </p>
                <button type="submit" class="checkout-button" name="checkout">Proceed to Checkout</button>
            </div>
        </form>
    </div>

    <?php include ("../Components/footer.php"); ?>
    <script src="../Scripts/remove_cart_item.js"></script>
</body>

</html>
