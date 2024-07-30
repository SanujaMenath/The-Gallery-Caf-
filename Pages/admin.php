<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all cuisine items
$cuisine_items_query = "SELECT * FROM cuisine_items";
$cuisine_items_result = mysqli_query($conn, $cuisine_items_query);

if (!$cuisine_items_result) {
    die("Error fetching cuisine items: " . mysqli_error($conn));
}

// Fetch all reservations
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = mysqli_query($conn, $reservations_sql);

if (!$reservations_result) {
    die("Error fetching reservations: " . mysqli_error($conn));
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
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">
            <h1>Admin Dashboard - The Gallery Café</h1>
            <nav class="admin-nav">
                <ul>
                    <li><a href="./manage_users.php">Manage Users</a></li>
                    <li><a href="./manage_beverages.php"> Manage Beverages</a></li>
                    <li><a href="#manage-cuisine-items">Cuisine-Items</a></li>
                    <li><a href="#view-reservations">View Reservations</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>

            <!-- Manage Cuisine-Items -->

            <section id="manage-cuisine-items">
                <h2>Manage Cuisine Items</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cuisine Type</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cuisine_item = $cuisine_items_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $cuisine_item['id']; ?></td>
                                <td><?php echo htmlspecialchars($cuisine_item['cuisine_type']); ?></td>
                                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($cuisine_item['image']); ?>"
                                        alt="Cuisine Image" style="width:150px; height:100px;" /></td>
                                <td><?php echo htmlspecialchars($cuisine_item['description']); ?></td>
                                <td>
                                    <a href="delete_cuisine_item.php?id=<?php echo $cuisine_item['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this cuisine item?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="add_cuisine_item.php" class="admin-button">Add Cuisine Item</a>
            </section>

            <!-- Reservation- section -->
            <section id="view-reservations">
                <h2>View Reservations</h2>
                <table class="admin-table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>People</th>
                        <th>Requests</th>
                    </tr>
                    <?php while ($reservation = $reservations_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $reservation['name']; ?></td>
                            <td><?php echo $reservation['email']; ?></td>
                            <td><?php echo $reservation['phone']; ?></td>
                            <td><?php echo $reservation['date']; ?></td>
                            <td><?php echo $reservation['time']; ?></td>
                            <td><?php echo $reservation['people']; ?></td>
                            <td><?php echo $reservation['requests']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>

<?php
$conn->close();
?>