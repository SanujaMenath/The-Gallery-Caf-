<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Check if file was uploaded without errors
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // SQL query to insert the new promotion
        $sql = "INSERT INTO promotions (name, description, image) 
                VALUES ('$name', '$description', '$imgContent')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Promotion added successfully!'); window.location.href = './manage_promotion.php';</script>";
        } else {
            echo "<script>alert('Error adding promotion: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Please upload an image.');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/add_user.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="admin-main-content">
        <div class="admin-container">
        <div class="login-container"> 
            <h1>Add Promotion</h1>
            <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                </div>

                <div class="input-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                </div>

                <div class="input-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required>
                </div>

                <div class="button-group"></div>
                <button type="submit">Add Promotion</button>
                </div>
            </form>
            </div>
            <a href="./manage_promotion.php">Cancel</a>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>
