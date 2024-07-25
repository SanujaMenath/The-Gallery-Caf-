<?php
session_start();
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
</head>

<body>
    <!-- header section -->
    <div class="header">
        <nav>
            <div class="header-top">
                <div class="contact-info-header">
                    <span class="phone-number">
                        <img src="../Assets/icons/phone-call.png" alt="Phone" /> +941 122 5580
                    </span>
                </div>
                <img src="../Assets/logo.jpg" alt="The Gallery Café" class="logo" />
                <div class="header-right">
                    <a href="#" class="search">
                        <img src="../Assets/icons/search.png" alt="Search" />
                    </a>

                    <a href="../Pages/cart.html" class="cart">
                        <img src="../Assets/icons/shopping-cart.png" alt="Cart" />
                    </a>

                    <?php if (!isset($_SESSION['role'])): ?>
                        <a href="../Pages/login.html" class="register">
                            <img src="../Assets/icons/register.png" alt="Login" /> Login
                        </a>
                    <?php else: ?>
                        <a href="../Pages/user.html" class="register">
                            <img src="../Assets/icons/register.png" alt="User" />
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role'])): ?>
                        <a href="../Pages/logout.php" class="register">
                            Logout
                        </a>
                    <?php endif; ?>

                </div>
            </div>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="./menu.php">Menu</a></li>
                <li><a href="./reservation.php">Reservations</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="./admin.php">Dashboard</a></li>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>
                    <li><a href="./staff.php">Dashboard</a></li>
                <?php endif; ?>

                <li><a href="./aboutUs.php">About Us</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>

  <!-- admin-dashboard -->
<div class="admin-main-content">
    <div class="admin-container">
        <h1>Admin Dashboard - The Gallery Café</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="#manage-users">Manage Users</a></li>
                <li><a href="#manage-items">Manage Food & Beverages</a></li>
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
                        <th>Created At</th>
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
                            <td><?php echo $item['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="add_beverage.php" class="admin-button">Add Beverages</a>
        </div>

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
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>The Gallery Café</h2>
                <p>
                    Welcome to The Gallery Café, where we blend the love for art and
                    food. Enjoy our carefully curated menu and the artistic ambiance.
                </p>
            </div>
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../Pages/menu.html">Menu</a></li>
                    <li><a href="../Pages/reservation.html">Reservations</a></li>
                    <li><a href="../Pages/aboutUs.html">About Us</a></li>
                    <li><a href="../Pages/contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Contact Us</h2>
                <ul>
                    <li>Email: info@gallerycafe.com</li>
                    <li>Phone: +1 234 567 890</li>
                    <li>Address: 123 Art St, Creativity City</li>
                </ul>
                <div class="social-media" style="margin-top: 10px">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>

<?php
$conn->close();
?>