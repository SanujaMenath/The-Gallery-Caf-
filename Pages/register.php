<?php
session_start();

// Database configuration
include("../db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
    $lastname = mysqli_real_escape_string($conn, trim($_POST['lastname']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else {
        // Check if the username or email already exists
        $check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username or email already exists!');</script>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (first_name, last_name, username, password, email, role)
                    VALUES ('$firstname', '$lastname', '$username', '$hashed_password', '$email', 'customer')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Registration successful! You can now log in.'); window.location.href = './login.html';</script>";
                exit();
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/register.css">
    <link rel="stylesheet" href="../Styles/footer.css">
</head>

<body>
    <!-- Header -->
    <?php include ("../Components/header.php"); ?>

    <!-- Register form -->
    <div class="register-container">
        <h1>Register - The Gallery Café</h1>
        <form action="" method="post">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="./login.php">Login here</a></p>
    </div>

    <!-- Footer-Section -->
    <?php include ("../Components/footer.php"); ?>

</body>

</html>
