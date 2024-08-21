<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch the cuisine item to be edited
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cuisine_item_query = "SELECT * FROM cuisine_items WHERE id = $id";
    $cuisine_item_result = mysqli_query($conn, $cuisine_item_query);

    if (!$cuisine_item_result) {
        die("Error fetching cuisine item: " . mysqli_error($conn));
    }

    $cuisine_item = mysqli_fetch_assoc($cuisine_item_result);

    if (!$cuisine_item) {
        die("Cuisine item not found.");
    }
} else {
    die("Invalid cuisine item ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuisine_type = mysqli_real_escape_string($conn, $_POST['cuisine_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $update_query = "UPDATE cuisine_items SET cuisine_type = '$cuisine_type', description = '$description', image = '$image' WHERE id = $id";
    } else {
        $update_query = "UPDATE cuisine_items SET cuisine_type = '$cuisine_type', description = '$description' WHERE id = $id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Cuisine item updated successfully!'); window.location.href='manage_cuisine_item.php';</script>";
    } else {
        echo "<script>alert('Error updating cuisine item: " . mysqli_error($conn) . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cuisine Item</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        h1{
            color:white;
        }
        .admin-container {
            position: relative;
            overflow: hidden;
        }
        .admin-container::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;   
            filter: blur(10px);
            z-index: -1;
        }
        form {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.8); /* Add a semi-transparent background to the form for better readability */
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container" style="background-image: url('data:image/jpeg;base64,<?php echo base64_encode($cuisine_item['image']); ?>'); ">

            <!-- Edit Cuisine Item -->
            <section id="edit-cuisine-item">
                <h2>Edit Cuisine Item</h2>
                <form action="" method="post" enctype="multipart/form-data">

                    <label for="cuisine_type">Cuisine Type:</label>
                    <input type="text" id="cuisine_type" name="cuisine_type"
                        value="<?php echo htmlspecialchars($cuisine_item['cuisine_type']); ?>" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description"
                        required><?php echo htmlspecialchars($cuisine_item['description']); ?></textarea>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    

                    <button type="submit" >Update Cuisine Item</button>
                </form>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>

</body>

</html>