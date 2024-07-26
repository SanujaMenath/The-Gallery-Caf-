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

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string(trim($_POST['firstname']));
    $lastname = $conn->real_escape_string(trim($_POST['lastname']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $_POST['password'];
    $email = $conn->real_escape_string(trim($_POST['email']));
    
    // Validate input
    if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($email)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        // Check if the username or email already exists
        $check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $message = "Username or email already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert the new user into the database
            $sql = "INSERT INTO users (first_name, last_name, username, password, email, role)
                    VALUES ('$firstname', '$lastname', '$username', '$hashed_password', '$email', 'customer')";
            
            if ($conn->query($sql) === TRUE) {
                $message = "Registration successful! You can now log in.";
                //  Redirect to login page
                //  header("Location: ./login.html");
                //  exit();
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/register.css">
</head>
<body>
    <div class="register-container">
        <h1>Register - The Gallery Café</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
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
        <p>Already have an account? <a href="./login.html">Login here</a></p>
    </div>
</body>
</html>
