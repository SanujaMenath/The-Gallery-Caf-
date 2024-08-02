<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // SQL Query to insert the new product into the database
        $sql = "INSERT INTO cuisine_items (cuisine_type, image, description) VALUES ('$name', '$imgContent', '$description')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
               alert('Cuisine Type added successfully!');  window.location.href = './manage_cuisine_item.php';  </script>";


        } else {
            echo "<script> alert('Error: " . mysqli_error($conn) . "');   window.location.href = 'manage_cuisine_item.php';   </script>";
        }
    } else {
        echo "<script> alert('Error uploading image. Please try again.'); window.location.href = 'manage_cuisine_item.php'; </script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cuisine Item - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/add_user.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- Add -->
    <div class="admin-main-content">
        <div class="admin-container">
            <div class="login-container">
                <h1>Add Cuisine Item</h1>
                <form action="add_cuisine_item.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="input-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="input-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="button-group">
                        <button type="submit">Add Cuisine Item</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- footer section -->
    <?php include ("../Components/footer.php"); ?>

</body>

</html>