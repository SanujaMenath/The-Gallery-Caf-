<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Fetch staff details
$staff_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $staff_id";
$result = mysqli_query($conn, $sql);
$staff = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['new_username'];
    $firstName =  $_POST['first_name'];
    $lastName =  $_POST['last_name'];

    $sql = "UPDATE users SET username = '$username', first_name = '$firstName', last_name = '$lastName' WHERE id = $staff_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $new_username;
        echo "<script>alert('Changed profile details successfully!'); window.location.href = './staff.php';</script>";
    } else {
        echo "<script>alert('Unsuccessful attempt!'); window.location.href = './staff.php';</script>";
    }

        // Check if a profile image was uploaded
        if (mysqli_query($conn, $sql)) {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $image = file_get_contents($_FILES['profile_image']['tmp_name']);
            $image = mysqli_real_escape_string($conn, $image);
            $sql = "UPDATE users SET profile_image = '$image' WHERE id = $staff_id";
            mysqli_query($conn, $sql);
            echo "<script>alert('Changed profile details successfully!'); window.location.href = './staff.php';</script>";
        }   header("Location: staff.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        echo "<script>alert('Unsuccessful attempt!'); window.location.href = './staff.php';</script>";
    }

      
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/staff.css">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header Section -->
    <?php include("../Components/header.php"); ?>

    <!-- staff-Dashboard -->
    <div class="staff-container">
        <h1>Staff Dashboard - The Gallery Café</h1>
        <nav>
            <ul>
                <li><a href="./staff.php">Profile</a></li>
                <li><a href="./staff_manage_reservation.php">View Reservations</a></li>
                <li><a href="./staff_manage_preorder.php">Process Pre-orders</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Profile Section -->    
        <div class="profile-container">
            <h1>My Profile</h1>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="pro-pic">
                    <?php if ($staff['profile_image']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($staff['profile_image']); ?>"
                            alt="Profile Image" width="100">
                    <?php endif; ?>
                </div>
                <label for="profile_image">Change Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">

                <label for="username">Username:</label>
                <input type="text" id="new_username" name="new_username"
                    value="<?php echo htmlspecialchars($staff['username']); ?>" >

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($staff['first_name']); ?>" >

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($staff['last_name']); ?>" >
                <br>
                <div class="change-password">
                    <a href="./change_password.php">Change Password </a>
                </div>
                <button type="submit">Update Profile</button>
            </form>
        </div>

    </div>

    <!-- footer-section -->
    <?php include("../Components/footer.php"); ?>
</body>

</html>
