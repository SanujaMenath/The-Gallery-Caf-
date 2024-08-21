<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include("../db.php");

// Check if the promotion ID is set
if (isset($_GET['id'])) {
    $promotion_id = $_GET['id'];

    // Fetch promotion details
    $promotion_sql = "SELECT * FROM promotions WHERE id = '$promotion_id'";
    $promotion_result = mysqli_query($conn, $promotion_sql);

    if ($promotion_result && mysqli_num_rows($promotion_result) > 0) {
        $promotion = mysqli_fetch_assoc($promotion_result);
    } else {
        die("Error fetching promotion: " . mysqli_error($conn));
    }
} else {
    header("Location: ./admin.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
    } else {
        $imgContent = $promotion['image'];
    }

    // SQL query to update the promotion
    $sql = "UPDATE promotions SET  name='$name',   description='$description', image='$imgContent' WHERE id='$promotion_id'";          

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Promotion updated successfully!'); window.location.href = './manage_promotion.php';</script>";
    } else {
        echo "<script>alert('Error updating promotion: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion - The Gallery Café</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <div class="admin-main-content">
        <div class="admin-container">
            <h1>Edit Promotion</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($promotion['name']); ?>" >

                <label for="description">Description:</label>
                <textarea id="description" name="description" ><?php echo htmlspecialchars($promotion['description']); ?></textarea>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
                <?php if ($promotion['image']) { ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>" alt="promotion-image" style="width:150px; height:100px;" />
                <?php } ?>

                <button type="submit">Update Promotion</button>
            </form>
        </div>
    </div>

    <!-- footer-section -->
    <?php include ("../Components/footer.php"); ?>
</body>

</html>
