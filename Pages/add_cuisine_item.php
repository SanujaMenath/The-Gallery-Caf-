<?php
session_start();
// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

 include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Check if file was uploaded without errors
  
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // SQL Query to insert the new product into the database
        $sql = "INSERT INTO cuisine_items (cuisine_type, image,description) VALUES ('$name', '$imgContent', '$description')";

        if(mysqli_query($conn, $sql)){
            echo "<script>
               alert('Cuisine Type added successfully!'); 
               window.location.href = 'admin.php';
            </script>";
         } else {
            echo "<script>
               alert('Error: " . mysqli_error($conn) . "');
               window.location.href = 'admin.php';
            </script>";
         }
}

//Close the database connection
mysqli_close($conn);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <input type="file" id="image" name="image" accept="image/*">

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