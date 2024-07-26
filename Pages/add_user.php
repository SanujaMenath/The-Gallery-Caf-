<?php
session_start();

// Check if the user is not an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: unauthorized.php"); // Redirect to unauthorized access page if user is not an admin
    exit();
}

// Database connection
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"  && ($_SESSION['role'] === "admin")) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    
    // SQL query to insert new user
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, role, created_at) 
            VALUES ('$first_name', '$last_name', '$username', '$password', '$email', '$role', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>New user created successfully</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/login.css">
    <title>Add New User - The Gallery Café</title>
</head>
<body>
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
                    <option value="customer">Customer</option>
                </select>
            </div>
            <button type="submit">Add User</button>
            <a href="./admin.php"> <button type="submit">Go Back</button></a>
        </form>
    </div>
</body>
</html>
