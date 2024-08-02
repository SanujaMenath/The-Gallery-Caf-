<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Update featured status
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $update_query = "UPDATE menu_item SET is_featured = $is_featured WHERE id = $id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_menu_item.php");
    } else {
        echo "Error updating featured status: " . mysqli_error($conn);
    }
} else {
    header("Location:  manage_menu_item.php");
}

mysqli_close($conn);
?>
