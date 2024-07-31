<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all beverages
$items_query = "SELECT * FROM beverages";
$items_result = mysqli_query($conn, $items_query);

if (!$items_result) {
    die("Error fetching beverages: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">
            
        <?php include ("../Components/admin_header.php"); ?>
        
            <!-- Manage Beverages Section -->
            <div id="manage-items" class="dashboard-section">
                <h2>Manage Beverages</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price (Regular)</th>
                            <th>Price (Large)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['id']); ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>"
                                             alt="beverage-item" style="width:150px; height:100px;" />
                                    <?php else: ?>
                                        No image available
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['price_regular']); ?></td>
                                <td><?php echo htmlspecialchars($item['price_large']); ?></td>
                                <td>
                                    <a href="edit_beverage.php?id=<?php echo urlencode($item['id']); ?>">Edit</a> |
                                    <a href="delete_beverage.php?id=<?php echo urlencode($item['id']); ?>"
                                        onclick="return confirm('Are you sure you want to delete this beverage?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="add_beverage.php" class="admin-button">Add Beverages</a>
            </div>
        </div>
    </div>
                                            
    <!-- Footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>
