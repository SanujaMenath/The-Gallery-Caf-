<?php
session_start();
include("../db.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['beverage_id'])) {
        $beverage_id = intval($_POST['beverage_id']);
        $menu_id = null;
        $quantity = intval($_POST['quantity']);
    } elseif (isset($_POST['menu_id'])) {
        $menu_id = intval($_POST['menu_id']);
        $beverage_id = null;
        $quantity = intval($_POST['quantity']);
    } else {
        die("Invalid request.");
    }

    // Check if the item is already in the cart
    $sql = "SELECT id FROM cart WHERE username = ? AND beverage_id = ? AND menu_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $username, $beverage_id, $menu_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Item is already in the cart, update the quantity
        $sql = "UPDATE cart SET quantity = quantity + ? WHERE username = ? AND beverage_id = ? AND menu_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isis", $quantity, $username, $beverage_id, $menu_id);
    } else {
        // Item is not in the cart, insert a new record
        $sql = "INSERT INTO cart (username, beverage_id, menu_id, quantity) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "siii", $username, $beverage_id, $menu_id, $quantity);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Item added to cart successfully!'); window.location.href = 'view_all_meals.php';</script>";
    } else {
        echo "<script>alert('Failed to add item to cart. Please try again.'); window.location.href = 'view_all_meals.php';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
