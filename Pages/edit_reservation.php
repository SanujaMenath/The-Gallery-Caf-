<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$message = '';

// Fetch reservation data if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute SQL query
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if reservation exists
    if ($result->num_rows == 1) {
        $reservation = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Reservation not found.'); window.location.href = 'view_reservations.php';</script>";
        exit();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
        $date = mysqli_real_escape_string($conn, trim($_POST['date']));
        $time = mysqli_real_escape_string($conn, trim($_POST['time']));
        $people = mysqli_real_escape_string($conn, trim($_POST['people']));
        $requests = mysqli_real_escape_string($conn, trim($_POST['requests']));

        // Update reservation in the database
        $update_sql = "UPDATE reservations SET name=?, email=?, phone=?, date=?, time=?, people=?, requests=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $name, $email, $phone, $date, $time, $people, $requests, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Reservation updated successfully!'); window.location.href = 'manage_reservation.php';</script>";
        } else {
            echo "<script>alert('Error updating reservation.'); window.location.href = 'manage_reservation.php';</script>";
        }
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Invalid reservation ID.'); window.location.href = 'manage_reservation.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
</head>

<body>
    <!-- Header -->
    <?php include("../Components/header.php"); ?>

    <!-- Admin Dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">
            <?php include("../Components/admin_header.php"); ?>

            <!-- Edit Reservation Section -->
            <section id="edit-reservation">
                <h2>Edit Reservation</h2>
                <form action="" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reservation['email']); ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($reservation['phone']); ?>" required>

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($reservation['date']); ?>" required>

                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($reservation['time']); ?>" required>

                    <label for="people">People:</label>
                    <input type="number" id="people" name="people" value="<?php echo htmlspecialchars($reservation['people']); ?>" required>

                    <label for="requests">Requests:</label>
                    <textarea id="requests" name="requests"><?php echo htmlspecialchars($reservation['requests']); ?></textarea>

                    <button type="submit">Update Reservation</button>
                </form>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../Components/footer.php"); ?>
</body>

</html>
