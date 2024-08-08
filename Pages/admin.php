<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Fetch admin details
$admin_id = $_SESSION['user_id']; // Admin ID is stored in session
$sql = "SELECT * FROM users WHERE id = $admin_id";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['newusername']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);

    // Check if the new username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$new_username' AND id != $admin_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.'); window.location.href = './admin.php';</script>";
    } else {
        // Update username, first name, and last name
        $sql = "UPDATE users SET username = '$new_username', first_name = '$firstName', last_name = '$lastName' WHERE id = $admin_id";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $new_username;

            // Check if a new profile image is uploaded
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $image = file_get_contents($_FILES['profile_image']['tmp_name']);
                $image = mysqli_real_escape_string($conn, $image);

                $image_sql = "UPDATE users SET profile_image = '$image' WHERE id = $admin_id";
                if (mysqli_query($conn, $image_sql)) {
                    echo "<script>alert('Profile updated successfully!'); window.location.href = './admin.php';</script>";
                } else {
                    echo "<script>alert('Profile details updated, but failed to update profile image.'); window.location.href = './admin.php';</script>";
                }
            } else {
                echo "<script>alert('Profile details updated successfully!'); window.location.href = './admin.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to update profile details.'); window.location.href = './admin.php';</script>";
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
    <title>Admin Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

     <!-- Admin dashboard -->
     <div class="admin-main-content">
        <!-- Side panel -->
         <?php include("../components/admin_header.php"); ?>

        <!-- Admin Profile -->
        <div class="admin-container">
            <h1 class="admin-header">Admin Profile</h1>
            <section>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pro-pic">
                        <?php if ($admin['profile_image']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($admin['profile_image']); ?>"
                                alt="Profile Image" width="100">
                        <?php else: ?>
                            <img src="../Images/default_profile.jpg" alt="Default Profile Image" width="100">
                        <?php endif; ?>
                    </div>
                    <label for="profile_image">Change Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">

                    <label for="username">Username:</label>
                    <input type="text" id="newusername" name="newusername"
                        value="<?php echo htmlspecialchars($admin['username']); ?>" >

                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name"
                        value="<?php echo htmlspecialchars($admin['first_name']); ?>" >

                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name"
                        value="<?php echo htmlspecialchars($admin['last_name']); ?>" >
                    <br>
                    <div class="change-password">
                        <a href="./change_password.php">Change Password</a>
                    </div>
                    <button type="submit">Update Profile</button>
                </form>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>
