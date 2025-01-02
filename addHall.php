<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $hallName = mysqli_real_escape_string($conn, $_POST['hallName']);
    $hallCapacity = intval($_POST['hallCapacity']);
    $hallLocation = mysqli_real_escape_string($conn, $_POST['hallLocation']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $hallLayout = $_FILES['hallLayout']['tmp_name'];

    if (!empty($hallLayout)) {
        $layoutContent = addslashes(file_get_contents($hallLayout));
        $sql = "INSERT INTO hall (hallName, hallCapacity, hallLocation, managerID, hallLayout)
                VALUES ('$hallName', '$hallCapacity', '$hallLocation', '$managerID', '$layoutContent')";
    } else {
        $sql = "INSERT INTO hall (hallName, hallCapacity, hallLocation, managerID)
                VALUES ('$hallName', '$hallCapacity', '$hallLocation', '$managerID')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Hall added successfully!'); window.location.href = 'viewHall.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Hall</title>
    <link rel="stylesheet" href="addFoodsup.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <form action="addHall.php" method="POST" enctype="multipart/form-data">
        <label for="hallName">Hall Name:</label>
        <input type="text" id="hallName" name="hallName" required>
        
        <label for="hallCapacity">Capacity:</label>
        <input type="number" id="hallCapacity" name="hallCapacity" required>
        
        <label for="hallLocation">Location:</label>
        <input type="text" id="hallLocation" name="hallLocation" required>
        
        <label for="managerID">Manager ID:</label>
        <input type="text" id="managerID" name="managerID" required>
        
        <label for="hallLayout">Upload Layout:</label>
        <input type="file" id="hallLayout" name="hallLayout" accept="image/*">
        
        <button type="submit" name="submit">Add Hall</button>
    </form>
</div>
</body>
</html>
