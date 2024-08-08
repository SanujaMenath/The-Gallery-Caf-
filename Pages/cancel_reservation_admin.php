<?php
session_start();
include ("../db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE reservations SET status = 'canceled' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ./manage_reservation.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    header("Location: ./manage_reservation.php");
}

$conn->close();
?>