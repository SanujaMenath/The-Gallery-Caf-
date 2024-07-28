<?php
session_start();
// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO cuisine_items (cuisine_type, image, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $image, $description);

        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cuisine Item - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/headerStyle.css">
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css">
</head>
<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

<!-- Add -->
    <div class="admin-main-content">
        <div class="admin-container">
            <h1>Add Cuisine Item</h1>
            <form action="add_cuisine_item.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                
                <button type="submit">Add Cuisine Item</button>
            </form>
        </div>
    </div>

    <!-- footer section -->
    <?php include ("../Components/footer.php"); ?>

</body>
</html>
