<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Fetch all menu items
$menu_items_query = "
    SELECT menu_item.id, menu_item.name, menu_item.description, menu_item.price, menu_item.image, menu_item.is_featured, cuisine_items.cuisine_type
    FROM menu_item
    LEFT JOIN cuisine_items ON menu_item.cuisine_item = cuisine_items.id";
$menu_items_result = mysqli_query($conn, $menu_items_query);

if (!$menu_items_result) {
    die("Error fetching menu items: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Menu Items</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header section -->
    <?php include("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
    <?php include("../Components/admin_header.php"); ?>
    
        <div class="admin-container">
         

            <!-- Manage Menu Items Section -->
            <div id="manage-menu-items" class="dashboard-section">
                <h2>Manage Menu Items</h2>
                <table class="admin-table">
                    <thead>
                        <tr>                           
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Cuisine Type</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($menu_items_result)): ?>
                            <tr>                               
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td style="max-width: 420px;"><?php echo htmlspecialchars($item['description']); ?></td>
                                <td><?php echo htmlspecialchars($item['price']); ?></td>
                                <td>
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>"
                                             alt="menu-item" style="width:150px; height:100px;" />
                                    <?php else: ?>
                                        No image available
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['cuisine_type']); ?></td>
                                <td>
                                    <form method="post" action="update_featured_items.php">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <input type="checkbox" name="is_featured" value="1" <?php echo $item['is_featured'] ? 'checked' : ''; ?>>
                                        <button  style="max-width: 100px;">click</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_menu_item.php?id=<?php echo urlencode($item['id']); ?>">Edit</a> |
                                    <a href="delete_menu_item.php?id=<?php echo urlencode($item['id']); ?>"
                                       onclick="return confirmDelete();">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="add_menu_item.php" class="admin-button">Add Menu Item</a>
            </div>
        </div>
    </div>

    <!-- Footer section -->
    <?php include("../Components/footer.php"); ?>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this menu item?');
        }
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
