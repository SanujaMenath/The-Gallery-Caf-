<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

if (isset($_GET['id'])) {
    $pre_order_id = $_GET['id'];

    // Update the status of the pre-order to 'Confirmed'
    $sql = "UPDATE pre_orders SET status = 'Confirmed' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pre_order_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Order confirmed successfully!'); window.location.href = './staff_manage_preorder.php';</script>";
    } else {
        echo "<script>alert('Failed to confirm order. Please try again.'); window.location.href = './staff_manage_preorder.php';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
