<?php
session_start();
// Check if the user is staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ./unauthorized.php");
    exit();
}

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

// Fetch all reservations
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = $conn->query($reservations_sql);

// Fetch all pre-orders
$pre_orders_sql = "SELECT * FROM pre_orders";
$pre_orders_result = $conn->query($pre_orders_sql);

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
<include>
     <!-- Header Section -->
     <?php include ("../Components/header.php"); ?>

    <!-- staff-Dashboard -->
    <div class="staff-container">
        <h1>Staff Dashboard - The Gallery Café</h1>
        <nav>
            <ul>
                <li><a href="#view-reservations">View Reservations</a></li>
                <li><a href="#process-pre-orders">Process Pre-orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

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

        <section id="process-pre-orders">
            <h2>Process Pre-orders</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Order Details</th>
                    <th>Actions</th>
                </tr>
                <?php while ($pre_order = $pre_orders_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $pre_order['name']; ?></td>
                    <td><?php echo $pre_order['email']; ?></td>
                    <td><?php echo $pre_order['phone']; ?></td>
                    <td><?php echo $pre_order['order_details']; ?></td>
                    <td>
                        <a href="confirm_pre_order.php?id=<?php echo $pre_order['id']; ?>">Confirm</a> |
                        <a href="modify_pre_order.php?id=<?php echo $pre_order['id']; ?>">Modify</a> |
                        <a href="cancel_pre_order.php?id=<?php echo $pre_order['id']; ?>">Cancel</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </section>
    </div>

      <!-- footer-section -->
      <?php include ("../Components/footer.php"); ?>
</body>
</html>

<?php
$conn->close();
?>
