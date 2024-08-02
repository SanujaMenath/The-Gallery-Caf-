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
$reservation = null;
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
        $reason = mysqli_real_escape_string($conn, trim($_POST['reason']));

        // Update reservation status to canceled
        $update_sql = "UPDATE reservations SET status='canceled', cancellation_reason=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "si", $reason, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Send email to the user
            $to = $reservation['email'];
            $subject = "Table Reservation " . $id;
            $message = "Dear " . $reservation['name'] . ",\n\n";
            $message .= "We regret to inform you that your reservation with ID " . $id . " has been canceled.\n";
            $message .= "Reason for cancellation: " . $reason . "\n\n";
            $message .= "Thank you for your understanding.\n";
            $message .= "Best regards,\nThe Gallery Café";

            $headers = "From: no-reply@thegallerycafe.com\r\n";
            $headers .= "Reply-To: no-reply@thegallerycafe.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('Reservation canceled and email sent successfully!'); window.location.href = 'view_reservations.php';</script>";
            } else {
                echo "<script>alert('Failed to send email.'); window.location.href = 'view_reservations.php';</script>";
            }
        } else {
            echo "<script>alert('Error updating reservation.'); window.location.href = 'view_reservations.php';</script>";
        }

        mysqli_stmt_close($stmt);
    }
} else {
    echo "<script>alert('Invalid reservation ID.'); window.location.href = 'view_reservations.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Reservation</title>
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

            <!-- Cancel Reservation Section -->
            <section id="cancel-reservation">
                <h2>Cancel Reservation</h2>
                <form action="" method="post">
                    <label for="reason">Reason for Cancellation:</label>
                    <textarea id="reason" name="reason" required></textarea>

                    <button type="submit">Submit Cancellation</button>
                </form>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../Components/footer.php"); ?>
</body>

</html>
