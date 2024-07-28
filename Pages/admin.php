<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}
// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);

if (!$users_result) {
    die("Error fetching users: " . $conn->error);
}

// Fetch all beverages
$items_query = "SELECT * FROM beverages";
$items_result = $conn->query($items_query);

if (!$items_result) {
    die("Error fetching beverages: " . $conn->error);
}

// Fetch all cuisine items
$cuisine_items_query = "SELECT * FROM cuisine_items";
$cuisine_items_result = $conn->query($cuisine_items_query);

if (!$cuisine_items_result) {
    die("Error fetching cuisine items: " . $conn->error);
}

// Fetch all reservations
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = $conn->query($reservations_sql);

if (!$reservations_result) {
    die("Error fetching reservations: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/headerStyle.css" />
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
                    <li><a href="#manage-users">Manage Users</a></li>
                    <li><a href="#manage-items"> Manage Beverages</a></li>
                    <li><a href="#manage-cuisine-items">Cuisine-Items</a></li>
                    <li><a href="#view-reservations">View Reservations</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>

            <section id="manage-users">
                <h2>Manage Users</h2>
                <table class="admin-table">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($user = $users_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <a href="add_user.php" class="admin-button">Add New User</a>
            </section>

            <!-- Manage Beverages Section -->
            <div id="manage-items" class="dashboard-section">
                <h2>Manage Beverages</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Add-ons</th>
                            <th>Price (Regular)</th>
                            <th>Price (Large)</th>
                            <th>Price (Add-ons)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $items_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['add_ons']; ?></td>
                                <td><?php echo $item['price_regular']; ?></td>
                                <td><?php echo $item['price_large']; ?></td>
                                <td><?php echo $item['price_add_ons']; ?></td>
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