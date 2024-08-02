<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch the beverage item to be edited
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $beverage_query = "SELECT * FROM beverages WHERE id = $id";
    $beverage_result = mysqli_query($conn, $beverage_query);

    if (!$beverage_result) {
        die("Error fetching beverage: " . mysqli_error($conn));
    }

    $beverage = mysqli_fetch_assoc($beverage_result);

    if (!$beverage) {
        die("Beverage not found.");
    }
} else {
    die("Invalid beverage ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price_regular = mysqli_real_escape_string($conn, $_POST['price_regular']);
    $price_large = mysqli_real_escape_string($conn, $_POST['price_large']);

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $update_query = "UPDATE beverages SET name = '$name', price_regular = '$price_regular', price_large = '$price_large', image = '$image' WHERE id = $id";
    } else {
        $update_query = "UPDATE beverages SET name = '$name', price_regular = '$price_regular', price_large = '$price_large' WHERE id = $id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Beverage item updated successfully!'); window.location.href='manage_beverages.php';</script>";
    } else {
        echo "<script>alert('Error updating beverage item: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beverage</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">

            <?php include ("../Components/admin_header.php"); ?>

            <!-- Edit Beverage Item -->
            <section id="edit-beverage-item">
                <h2>Edit Beverage Item</h2>
                <form action="" method="post" enctype="multipart/form-data">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($beverage['name']); ?>"
                        required>

                    <label for="price_regular">Price (Regular):</label>
                    <input type="number" id="price_regular" name="price_regular"
                        value="<?php echo htmlspecialchars($beverage['price_regular']); ?>" step="0.01" required>

                    <label for="price_large">Price (Large):</label>
                    <input type="number" id="price_large" name="price_large"
                        value="<?php echo htmlspecialchars($beverage['price_large']); ?>" step="0.01" required>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    <p>Current Image:</p>
                    <?php if (!empty($beverage['image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($beverage['image']); ?>"
                            alt="Beverage Image" style="width:150px; height:100px;" />
                    <?php else: ?>
                        No image available
                    <?php endif; ?>

                    <button type="submit">Update Beverage Item</button>
                </form>
            </section>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>

</body>

</html>