<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all reservations
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = $conn->query($reservations_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/staff.css">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Header Section -->
    <?php include ("../Components/header.php"); ?>
    <div class="dashboard">
    <div id="nav">
            <h1>Staff Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="./staff.php">Profile</a></li>
                    <li><a href="./staff_manage_reservation.php">View Reservations</a></li>
                    <li><a href="./staff_manage_preorder.php">Process Pre-orders</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        <!-- staff-Dashboard -->
        <div class="staff-container">
            
            <!-- Manage Reservation -->
            <section id="view-reservations">
                <h2>View Reservations</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>People</th>
                        <th>Requests</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($reservation = $reservations_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $reservation['name']; ?></td>
                            <td><?php echo $reservation['email']; ?></td>
                            <td><?php echo $reservation['phone']; ?></td>
                            <td><?php echo $reservation['date']; ?></td>
                            <td><?php echo $reservation['time']; ?></td>
                            <td><?php echo $reservation['people']; ?></td>
                            <td><?php echo $reservation['requests']; ?></td>
                            <td>
                                <a href="confirm_reservation.php?id=<?php echo $reservation['id']; ?>">Confirm</a> |
                                <a href="modify_reservation.php?id=<?php echo $reservation['id']; ?>">Modify</a> |
                                <a href="cancel_reservation.php?id=<?php echo $reservation['id']; ?>">Cancel</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>