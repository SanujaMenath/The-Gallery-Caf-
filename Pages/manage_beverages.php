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
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="admin-main-content">
        <div class="admin-container">
            <h1>Admin Dashboard - The Gallery Café</h1>
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
                        <?php while ($item = $items_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['image']; ?></td>
                                <td><?php echo $item['price_regular']; ?></td>
                                <td><?php echo $item['price_large']; ?></td>
                                <td>
                                    <a href="edit_beverage.php?id=<?php echo $item['id']; ?>">Edit</a> |
                                    <a href="delete_beverage.php?id=<?php echo $item['id']; ?>"
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

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>