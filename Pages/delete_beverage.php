<?php
session_start();
// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM beverages WHERE id = ?";
   // Prepare statement
   $stmt = mysqli_prepare($conn, $sql);

   if ($stmt === false) {
    die("Statement preparation failed: " . mysqli_error($conn));
}

     // Bind parameters
     mysqli_stmt_bind_param($stmt, "i", $id);

      // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to admin page
        echo "<script>alert('Beverage item deleted successfully!'); window.location.href='manage_beverages.php';</script>";
       
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
