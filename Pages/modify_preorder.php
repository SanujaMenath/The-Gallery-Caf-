<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

$pre_order = null; // Initialize variable

if (isset($_POST['submit'])) {
    $pre_order_id = $_POST['id'];
    $order_details = $_POST['order_details'];

    // Update the pre-order details
    $sql = "UPDATE pre_orders SET order_details = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $order_details, $pre_order_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Order modified successfully!'); window.location.href = './staff_manage_preorder.php';</script>";
    } else {
        echo "<script>alert('Failed to modify order. Please try again.'); window.location.href = './staff_manage_preorder.php';</script>";
    }

    mysqli_stmt_close($stmt);
} elseif (isset($_GET['id'])) {
    $pre_order_id = $_GET['id'];

    // Fetch the pre-order details
    $sql = "SELECT * FROM pre_orders WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pre_order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pre_order = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Pre-order</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="../Styles/modify_preorder.css">
</head>
<body>
    <?php include ("../Components/header.php"); ?>
    <div class="modify-order-container">
        <h1>Modify Pre-order</h1>
        <?php if ($pre_order): ?>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pre_order['id']); ?>">
                <label for="order_details">Order Details:</label>
                <textarea name="order_details" id="order_details" rows="10"><?php echo htmlspecialchars($pre_order['order_details']); ?></textarea>
                <button type="submit" name="submit">Modify Order</button>
            </form>
        <?php else: ?>
            <p>Order not found or invalid ID.</p>
        <?php endif; ?>
    </div>
    <?php include ("../Components/footer.php"); ?>
</body>
</html>
