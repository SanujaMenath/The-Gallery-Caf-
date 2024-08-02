<?php
session_start();
// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all promotions
$promotions_sql = "SELECT * FROM promotions";
$promotions_result = mysqli_query($conn, $promotions_sql);

if (!$promotions_result) {
    die("Error fetching promotions: " . mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
    <?php include("../Components/admin_header.php"); ?>

        <div class="admin-container">

            <!-- Promotion- section -->
            <section id="view-Promotion">
                <h2>View Promotions</h2>
                <table class="admin-table">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($promotion = $promotions_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $promotion['name']; ?></td>
                            <td style="max-width: 500px;"><?php echo $promotion['description']; ?></td>
                            <td><img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>"
                                    alt="Promotion" style="width:150px; height:100px;" /> </td>
                            <td> <a href="edit_promotion.php?id=<?php echo $promotion['id']; ?>">Edit</a> |
                                <a href="delete_promotion.php?id=<?php echo $promotion['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this promotion?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <a href="add_promotion.php" class="admin-button">Add New Promotion</a>
            </section>
        </div>
    </div>
</body>

</html>