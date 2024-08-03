<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch customer details
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $customer_id";
$result = mysqli_query($conn, $sql);
$customer = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['newusername'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    // Update username and names
    $sql = "UPDATE users SET username = '$new_username', first_name = '$firstName', last_name = '$lastName' WHERE id = $customer_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $new_username;
    } else {
        echo "<script>alert('Failed to update profile details!'); window.location.href = './customer_profile.php';</script>";
        exit();
    }

    // Update profile image if uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        // Read the file content
        $image = file_get_contents($_FILES['profile_image']['tmp_name']);
        $image = mysqli_real_escape_string($conn, $image);

        // Update profile image
        $sql = "UPDATE users SET profile_image = '$image' WHERE id = $customer_id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Profile image updated successfully!'); window.location.href = './customer_profile.php';</script>";
        } else {
            echo "<script>alert('Failed to update profile image!'); window.location.href = './customer_profile.php';</script>";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/customer_profile.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="main-content">

        <!-- Side panel -->
        <div class="side-panel">
            <h2>Navigation</h2>
            <ul>
                <li><a href="view_reservation.php">View Reservations</a></li>
                <li><a href="./cart.php">View Cart</a></li>
                <li><a href="./view_preorders.php">View Pre-Orders</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Customer Profile -->
        <div class="profile-container">
            <h1>Customer Profile</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="pro-pic">
                    <?php if (!empty($customer['profile_image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($customer['profile_image']); ?>"
                            alt="Profile Image" width="100">
                    <?php else: ?>
                        <img src="../Images/default_profile.jpg" alt="Default Profile Image" width="100">
                    <?php endif; ?>
                </div>
                <label for="profile_image">Change Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">

                <label for="username">Username:</label>
                <input type="text" id="newusername" name="newusername"
                    value="<?php echo htmlspecialchars($customer['username']); ?>">

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($customer['first_name']); ?>">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($customer['last_name']); ?>">

                <div class="change-password">
                    <a href="./change_password.php">Change Password</a>
                </div>
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>

    <!-- Footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>