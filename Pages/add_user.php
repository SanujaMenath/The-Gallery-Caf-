<?php
session_start();

// Check if the user is not an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: unauthorized.php"); // Redirect to unauthorized access page if user is not an admin
    exit();
}

// Database connection
include ("../db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_SESSION['role'] === "admin")) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // SQL query to insert new user
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, role, created_at) 
            VALUES ('$first_name', '$last_name', '$username', '$password', '$email', '$role', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo  "<script>alert('New User added successfully!'); </script>";
    } else {
        echo "<script>alert('Unsuccessful attempt!'); </script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="../Styles/add_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Add New User - The Gallery Café</title>
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="main-content">
        <div class="admin-container">

            <!-- Add users -->
            <div class="login-container">
                <h1>Add New User</h1>
                <form method="post" action="">
                    <div class="input-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="input-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    <div class="input-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="customer" disabled>Customer</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>