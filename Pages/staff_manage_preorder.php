<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all pre-orders
$pre_orders_sql = "SELECT * FROM pre_orders";
$pre_orders_result = $conn->query($pre_orders_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/staff.css">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <?php include ("../Components/header.php"); ?>

    <!-- staff-Dashboard -->
    <div class="staff-container">
        <h1>Staff Dashboard - The Gallery Café</h1>
        <nav>
            <ul>
                <li><a href="./staff.php">Profile</a></li>
                <li><a href="./staff_manage_reservation.php">View Reservations</a></li>
                <li><a href="./staff_manage_preorder.php">Process Pre-orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

<!-- Pre-orders section -->
        <section id="process-pre-orders">
            <h2>Process Pre-orders</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Order Details</th>
                    <th>Actions</th>
                </tr>
                <?php while ($pre_order = $pre_orders_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $pre_order['name']; ?></td>
                        <td><?php echo $pre_order['email']; ?></td>
                        <td><?php echo $pre_order['phone']; ?></td>
                        <td><?php echo $pre_order['order_details']; ?></td>
                        <td>
                            <a href="confirm_pre_order.php?id=<?php echo $pre_order['id']; ?>">Confirm</a> |
                            <a href="modify_pre_order.php?id=<?php echo $pre_order['id']; ?>">Modify</a> |
                            <a href="cancel_pre_order.php?id=<?php echo $pre_order['id']; ?>">Cancel</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>