<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch statistics
// Number of all users and categorized by role
$user_sql = "SELECT role, COUNT(*) AS count FROM users GROUP BY role";
$user_result = mysqli_query($conn, $user_sql);

$total_users = 0;
$staff_count = 0;
$customer_count = 0;

while ($row = mysqli_fetch_assoc($user_result)) {
    $total_users += $row['count'];
    if ($row['role'] === 'staff') {
        $staff_count = $row['count'];
    } elseif ($row['role'] === 'customer') {
        $customer_count = $row['count'];
    }
}

// Total reservations categorized by status
$reservation_sql = "SELECT status, COUNT(*) AS count FROM reservations GROUP BY status";
$reservation_result = mysqli_query($conn, $reservation_sql);

$total_reservations = 0;
$confirmed_reservations = 0;
$pending_reservations = 0;
$canceled_reservations = 0;

while ($row = mysqli_fetch_assoc($reservation_result)) {
    $total_reservations += $row['count'];
    if ($row['status'] === 'confirmed') {
        $confirmed_reservations = $row['count'];
    } elseif ($row['status'] === 'pending') {
        $pending_reservations = $row['count'];
    } elseif ($row['status'] === 'canceled') {
        $canceled_reservations = $row['count'];
    }
}

// Total pre-orders categorized by status
$preorder_sql = "SELECT status, COUNT(*) AS count FROM pre_orders GROUP BY status";
$preorder_result = mysqli_query($conn, $preorder_sql);

$total_preorders = 0;
$confirmed_preorders = 0;
$pending_preorders = 0;
$canceled_preorders = 0;

while ($row = mysqli_fetch_assoc($preorder_result)) {
    $total_preorders += $row['count'];
    if ($row['status'] === 'confirmed') {
        $confirmed_preorders = $row['count'];
    } elseif ($row['status'] === 'pending') {
        $pending_preorders = $row['count'];
    } elseif ($row['status'] === 'canceled') {
        $canceled_preorders = $row['count'];
    }
}

// Total number of beverages
$beverage_sql = "SELECT COUNT(*) AS count FROM beverages";
$beverage_result = mysqli_query($conn, $beverage_sql);
$beverage_count = mysqli_fetch_assoc($beverage_result)['count'];

// Total number of menu items
$menu_sql = "SELECT COUNT(*) AS count FROM menu_item";
$menu_result = mysqli_query($conn, $menu_sql);
$menu_count = mysqli_fetch_assoc($menu_result)['count'];

// Total number of events and promotions
$promotion_sql = "SELECT COUNT(*) AS count FROM promotions";
$promotion_result = mysqli_query($conn, $promotion_sql);
$promotion_count = mysqli_fetch_assoc($promotion_result)['count'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Statistics</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- Admin dashboard -->
    <div class="admin-main-content">
        <!-- Side panel -->
        <?php include("../components/admin_header.php"); ?>

        <!-- Admin Statistics -->
        <div class="admin-container">
            <h1 class="admin-header">Statistics of The Gallery Cafe </h1>
            <section>
                <h2>Users</h2>
                <p>Total Users: <?php echo $total_users; ?></p>
                <p>Staff: <?php echo $staff_count; ?></p>
                <p>Customers: <?php echo $customer_count; ?></p>

                <h2>Reservations</h2>
                <p>Total Reservations: <?php echo $total_reservations; ?></p>
                <p>Confirmed: <?php echo $confirmed_reservations; ?></p>
                <p>Pending: <?php echo $pending_reservations; ?></p>
                <p>Canceled: <?php echo $canceled_reservations; ?></p>

                <h2>Pre-orders</h2>
                <p>Total Pre-orders: <?php echo $total_preorders; ?></p>
                <p>Confirmed: <?php echo $confirmed_preorders; ?></p>
                <p>Pending: <?php echo $pending_preorders; ?></p>
                <p>Canceled: <?php echo $canceled_preorders; ?></p>

                <h2>Menu</h2>
                <p>Total Beverages: <?php echo $beverage_count; ?></p>
                <p>Total Menu Items: <?php echo $menu_count; ?></p>

                <h2>Events and Promotions</h2>
                <p>Ongoing Events & Promotions: <?php echo $promotion_count; ?></p>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>
