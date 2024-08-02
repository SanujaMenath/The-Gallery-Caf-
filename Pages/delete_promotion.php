<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect to unauthorized access page if user is not an admin
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query
    $sql = "DELETE FROM promotions WHERE id = ?";
    
    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Use JavaScript alert to indicate success
        echo "<script>
            alert('Promotion deleted successfully!');
           window.location.href = './manage_promotion.php'; 
        </script>";
    } else {
        // Use JavaScript alert to indicate error
        echo "<script>
            alert('Error deleting promotion: " . mysqli_stmt_error($stmt) . "');
          window.location.href = './manage_promotion.php'; 
        </script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Use JavaScript alert to indicate invalid ID
    echo "<script>
        alert('Invalid promotion ID.');
        window.location.href = './manage_promotion.php'; 
    </script>";
}

// Close the database connection
mysqli_close($conn);
?>
