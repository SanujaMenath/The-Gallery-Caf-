<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch customer reservations
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM reservations WHERE id = $customer_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reservations - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/view_reservation.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="main-content">
        <h1>Your Reservations</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>People</th>
                <th>Requests</th>
                <th>Status</th>
            </tr>
            <?php while ($reservation = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['name']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['email']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['phone']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['time']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['people']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['requests']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Footer section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>
<?php mysqli_close($conn); ?>
