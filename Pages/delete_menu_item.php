<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Check if the ID is set
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Prepare the delete statement
    $query = "DELETE FROM menu_item WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the delete statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Menu item deleted successfully!'); window.location.href='manage_menu_item.php';</script>";
        } else {
            echo "<script>alert('Error deleting menu item: " . mysqli_stmt_error($stmt) . "'); window.location.href='manage_menu_item.php';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare the delete statement.'); window.location.href='manage_menu_item.php';</script>";
    }
} else {
    echo "<script>alert('Invalid menu item ID.'); window.location.href='manage_menu_item.php';</script>";
}

mysqli_close($conn);
?>
