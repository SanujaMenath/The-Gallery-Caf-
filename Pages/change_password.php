<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: ./unauthorized.php");
    exit();
}

include("../db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $username = $_SESSION['username'];
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    $db_password = $user['password'];

    // Verify the current password
    if (!password_verify($current_password, $db_password)) {
        $error = 'Current password is incorrect.';
    } elseif ($new_password != $confirm_password) {
        $error = 'New passwords do not match.';
    } elseif (strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters long.';
    } else {
        // Update the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE username = '$username'";
        if ($conn->query($update_query) === TRUE) {
            $success = 'Password updated successfully.';
            header("Location: ./admin.php");
        } else {
            $error = 'Error updating password: ' . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/change_password.css">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <script>
        function validatePassword() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var errorMessage = '';

            if (newPassword.length < 6) {
                errorMessage = 'New password must be at least 6 characters long.';
            } else if (newPassword !== confirmPassword) {
                errorMessage = 'New passwords do not match.';
            }

            if (errorMessage) {
                alert(errorMessage);
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="main-content">
        <div class="container">
            <h1>Change Password</h1>
           
            <form action="change_password.php" method="POST" onsubmit="return validatePassword()">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>

    <!-- footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>