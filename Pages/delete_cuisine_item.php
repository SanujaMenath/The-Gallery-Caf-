<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query
    $sql = "DELETE FROM cuisine_items WHERE id = ?";
    
    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Cuisine item updated successfully!'); window.location.href='manage_cuisine_item.php';</script>";
    } else {
        // Output error message
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle the case where ID is not set
    echo "Error: Invalid ID.";
}

// Close the database connection
mysqli_close($conn);
?>
