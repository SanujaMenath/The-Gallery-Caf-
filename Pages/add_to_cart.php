<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $beverage_id = $_POST['beverage_id'];
    
    // Check if the item is already in the cart
    $sql = "SELECT id, quantity FROM cart WHERE username = ? AND beverage_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $beverage_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item is already in the cart, update the quantity
        $row = $result->fetch_assoc();
        $cart_id = $row['id'];
        $quantity = $row['quantity'] + 1;
        $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $cart_id);
    } else {
        // Item is not in the cart, insert a new row
        $sql = "INSERT INTO cart (username, beverage_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $username, $beverage_id);
    }

    if ($stmt->execute()) {
        // Redirect to beverages page after adding to cart
        header("Location: beverages.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
