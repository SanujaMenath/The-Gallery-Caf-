<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['role'])) {
        header("Location: ./login.php");
        exit();
    }
}

// Database configuration
include("../db.php");

// Fetch available tables
$tables_sql = "SELECT table_number, capacity FROM tables";
$tables_result = mysqli_query($conn, $tables_sql);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $people = mysqli_real_escape_string($conn, $_POST['people']);
    $requests = mysqli_real_escape_string($conn, $_POST['requests']);
    $table_number = mysqli_real_escape_string($conn, $_POST['table_number']);

    // Check the capacity of the selected table
    $capacity_sql = "SELECT capacity FROM tables WHERE table_number = '$table_number'";
    $capacity_result = mysqli_query($conn, $capacity_sql);
    $table_capacity = mysqli_fetch_assoc($capacity_result)['capacity'];

    if ($table_capacity < $people) {
        echo "<script>alert('The selected table cannot accommodate $people people.'); window.location.href = './reservation.php';</script>";
    } else {
        // Check if the table is available at the requested date and time
        $availability_sql = "SELECT COUNT(*) as count FROM reservations WHERE table_number = '$table_number' AND date = '$date' AND time = '$time'";
        $availability_result = mysqli_query($conn, $availability_sql);
        $table_count = mysqli_fetch_assoc($availability_result)['count'];

        if ($table_count > 0) {
            echo "<script>alert('The selected table is already reserved at the requested date and time.'); window.location.href = './reservation.php';</script>";
        } else {
            // SQL query to insert reservation
            $sql = "INSERT INTO reservations (name, email, phone, date, time, people, table_number, requests) VALUES ('$name', '$email', '$phone', '$date', '$time',$people, '$table_number', '$requests')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Reservation made successfully!'); window.location.href = './reservation.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = './reservation.php';</script>";
            }
        }
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/header.css">
    <link rel="stylesheet" href="../Styles/reservation.css">
    <link rel="stylesheet" href="../Styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>The Gallery Café - Reservations</title>
</head>
<body>
   <!-- header section -->
   <?php include ("../Components/header.php"); ?>

     <!-- reservation-section -->
     <div class="reservation-container">
        <h1>Reserve a Table</h1>
      
        <form class="reservation-form" action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="people">Number of People:</label>
            <input type="number" id="people" name="people" min="1" required>

            <label for="table_number">Table:</label>
            <select id="table_number" name="table_number" required>
                <option value="">Select a table</option>
                <?php
                while ($row = mysqli_fetch_assoc($tables_result)) {
                    echo "<option value='{$row['table_number']}'>Table {$row['table_number']} (Capacity: {$row['capacity']})</option>";
                }
                ?>
            </select>

            <label for="requests">Special Requests:</label>
            <textarea id="requests" name="requests"></textarea>

            <button type="submit">Reserve Now</button>     
        </form>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>
</html>