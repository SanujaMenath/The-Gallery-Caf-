<?php
session_start();

// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Get the reservation ID from the URL
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Fetch reservation details
    $sql = "SELECT * FROM reservations WHERE id = $reservation_id";
    $result = mysqli_query($conn, $sql);
    $reservation = mysqli_fetch_assoc($result);

    if (!$reservation) {
        echo "<script>alert('Reservation not found.'); window.location.href = './staff_manage_reservation.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No reservation ID provided.'); window.location.href = './staff_manage_reservation.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $requests = $_POST['requests'];

    // Update reservation details in the database
    $sql = "UPDATE reservations SET 
                name = '$name', 
                email = '$email', 
                phone = '$phone', 
                date = '$date', 
                time = '$time', 
                people = '$people', 
                requests = '$requests' 
            WHERE id = $reservation_id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Reservation updated successfully!'); window.location.href = './staff_manage_reservation.php';</script>";
    } else {
        echo "<script>alert('Failed to update reservation.'); window.location.href = './staff_manage_reservation.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Reservation</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="../Styles/modify_reservation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header Section -->
    <?php include ("../Components/header.php"); ?>

    <div class="form-container">
        <h1>Modify Reservation</h1>
        <form action="" method="POST">
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

            <label for="people">Number of People:</label>
            <input type="number" id="people" name="people" value="<?php echo htmlspecialchars($reservation['people']); ?>" required>

            <label for="requests">Special Requests:</label>
            <textarea id="requests" name="requests" required><?php echo htmlspecialchars($reservation['requests']); ?></textarea>

            <button type="submit">Update Reservation</button>
        </form>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>

<?php
mysqli_close($conn);
?>
