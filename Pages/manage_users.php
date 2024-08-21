<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Fetch all users
$users_sql = "SELECT * FROM users";
$users_result = mysqli_query($conn, $users_sql);

if (!$users_result) {
    die("Error fetching users: " . mysqli_error($conn));
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
    <?php include("../Components/header.php"); ?>


    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <?php include("../Components/admin_header.php"); ?>

        <div class="admin-container">

            <!-- View & Manage Users -->
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
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <a href="add_user.php" class="admin-button">Add New User</a>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include("../Components/footer.php"); ?>
</body>

</html>