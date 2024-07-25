<?php
// Database configuration
$servername = "localhost";
$username = "root"; // default MySQL username
$password = "root"; // default MySQL password
$dbname = "the_gallery_cafe"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$pass = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $user);

// Execute the statement
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    // Bind result
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $hashed_password)) {
        // Password is correct
        // Start session and set user role
        session_start();
        $_SESSION['username'] = $user;
        $_SESSION['role'] = $role;

        // Redirect based on role
        switch ($role) {
            case 'admin' || 'staff' || 'customer':
                header("Location: ../index.php");
                break;
            default:
                echo "Unknown role.";
                break;
        }
        exit;
    } else {
        // Password is incorrect
        echo "Invalid username or password.";
    }
} else {
    // User does not exist
    echo "Invalid username or password.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
