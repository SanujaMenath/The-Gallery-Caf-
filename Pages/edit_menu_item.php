<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch the menu item to be edited
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $menu_item_query = "SELECT * FROM menu_item WHERE id = $id";
    $menu_item_result = mysqli_query($conn, $menu_item_query);

    if (!$menu_item_result) {
        die("Error fetching menu item: " . mysqli_error($conn));
    }

    $menu_item = mysqli_fetch_assoc($menu_item_result);

    if (!$menu_item) {
        die("Menu item not found.");
    }
} else {
    die("Invalid menu item ID.");
}

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
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $update_query = "UPDATE menu_item SET name = '$name', description = '$description', price = '$price', image = '$image', cuisine_item = '$cuisine_item' WHERE id = $id";
    } else {
        $update_query = "UPDATE menu_item SET name = '$name', description = '$description', price = '$price', cuisine_item = '$cuisine_item' WHERE id = $id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Menu item updated successfully!'); window.location.href='manage_menu_item.php';</script>";
    } else {
        echo "<script>alert('Error updating menu item: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="../Styles/admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- Edit Menu Item -->
    <div class="admin-main-content">
        <div class="admin-container">
            <?php include ("../Components/admin_header.php"); ?>
            <section id="edit-menu-item">
                <h2>Edit Menu Item</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($menu_item['name']); ?>" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($menu_item['description']); ?></textarea>

                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($menu_item['price']); ?>" required>

                    <label for="cuisine_item">Cuisine Type:</label>
                    <select id="cuisine_item" name="cuisine_item" required>
                        <?php while ($cuisine = mysqli_fetch_assoc($cuisine_types_result)): ?>
                            <option value="<?php echo $cuisine['id']; ?>" <?php if ($cuisine['id'] == $menu_item['cuisine_item']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cuisine['cuisine_type']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">

                    <button type="submit">Update Menu Item</button>
                </form>
            </section>
        </div>
    </div>

    <!-- Footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>
