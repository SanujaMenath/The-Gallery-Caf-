<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

include("../db.php");

// Delete the product
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href = './manage_users.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Invalid product ID.'); window.location.href = './manage_users.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>