<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all cuisine types for the dropdown
$cuisine_types_query = "SELECT * FROM cuisine_items";
$cuisine_types_result = mysqli_query($conn, $cuisine_types_query);

if (!$cuisine_types_result) {
    die("Error fetching cuisine types: " . mysqli_error($conn));
}   

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cuisine_item = mysqli_real_escape_string($conn, $_POST['cuisine_item']);

    if (!empty($_FILES['image']['tmp_name'])) {
         $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $sql = "INSERT INTO menu_item (name, description, price, image, cuisine_item) VALUES ('$name', '$description', '$price', '$imgContent   ', '$cuisine_item')";
    } else {
        $sql = "INSERT INTO menu_item (name, description, price, cuisine_item) VALUES ('$name', '$description', '$price', '$cuisine_item')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Menu item added successfully!'); window.location.href='manage_menu_item.php';</script>";
    } else {
        echo "<script>alert('Error adding menu item: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item - Admin Dashboard</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/add_user.css">   
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">

            <!-- Add Menu Item Section -->
            <section id="add-menu-item">
                <div class="login-container">
                    <h2>Add Menu Item</h2>
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
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" step="0.01" required>
                        </div>

                        <div class="input-group">
                            <label for="cuisine_item">Cuisine Type:</label>
                            <select id="cuisine_item" name="cuisine_item" required>
                                <option value="">Select Cuisine Type</option>
                                <?php while ($cuisine = mysqli_fetch_assoc($cuisine_types_result)): ?>
                                    <option value="<?php echo $cuisine['id']; ?>">
                                        <?php echo htmlspecialchars($cuisine['cuisine_type']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="image">Image:</label>
                            <input type="file" id="image" name="image">
                        </div>

                        <div class="button-group">
                            <button type="submit">Add Menu Item</button>
                        </div>

                    </form>
                </div>
        </div>
        </section>
    </div>
    </div>

    <!-- Footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>