<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database configuration
include("../db.php");

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove_item_id'])) {
        $remove_item_id = $_POST['remove_item_id'];
        $sql = "DELETE FROM cart WHERE id = '$remove_item_id' AND username = '$username'";
        mysqli_query($conn, $sql);
        header("Location: cart.php");
        exit();
    }
}

mysqli_close($conn);
?>
