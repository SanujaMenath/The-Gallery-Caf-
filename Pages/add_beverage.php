<?php
session_start();

// Check if the user is not an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: unauthorized.php"); // Redirect to unauthorized access page if user is not an admin
    exit();
}

// Database config
include ("../db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
    } else {
        $imgContent = ''; // Or handle the case where no image is uploaded
    }

    $price_regular = mysqli_real_escape_string($conn, $_POST['price_regular']);
    $price_large = mysqli_real_escape_string($conn, $_POST['price_large']);

    // SQL query to insert new beverage
    $sql = "INSERT INTO beverages (name, image, price_regular, price_large)
            VALUES ('$name', '$imgContent', '$price_regular', '$price_large')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Beverage added successfully!'); window.location.href = './manage_beverages.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = './manage_beverages.php';</script>";
    }

    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/add_beverage.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Add Beverage - Admin Dashboard</title>
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-container -->
    <div class="admin-main-content ">
        <div class="admin-container">
            <h1>Add New Beverage</h1>

            <form action="" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="add_ons">Add Image:</label>
                <input type="file" name="image" accept="image/*">

                <label for="price_regular">Price (Regular):</label>
                <input type="number" id="price_regular" name="price_regular" step="0.01" required>

                <label for="price_large">Price (Large):</label>
                <input type="number" id="price_large" name="price_large" step="0.01" required>

                <button type="submit" class="admin-button">Add Beverage</button>
            </form>
        </div>
    </div>



    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>