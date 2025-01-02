<?php
include 'config.php';

if ($_GET['id']) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM hall WHERE hallID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $id = intval($_POST['hallID']);
    $hallName = mysqli_real_escape_string($conn, $_POST['hallName']);
    $hallCapacity = intval($_POST['hallCapacity']);
    $hallLocation = mysqli_real_escape_string($conn, $_POST['hallLocation']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $hallLayout = $_FILES['hallLayout']['tmp_name'];

    if (!empty($hallLayout)) {
        $layoutContent = addslashes(file_get_contents($hallLayout));
        $sql = "UPDATE hall SET hallName = '$hallName', hallCapacity = '$hallCapacity',
                hallLocation = '$hallLocation', managerID = '$managerID', hallLayout = '$layoutContent'
                WHERE hallID = $id";
    } else {
        $sql = "UPDATE hall SET hallName = '$hallName', hallCapacity = '$hallCapacity',
                hallLocation = '$hallLocation', managerID = '$managerID'
                WHERE hallID = $id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Hall updated successfully!'); window.location.href = 'viewHall.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Hall</title>
    <link rel="stylesheet" href="addFoodsup.css">
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>
    
    <form action="updateHall.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="hallID" value="<?php echo $row['hallID']; ?>">
        
        <label for="hallName">Hall Name:</label>
        <input type="text" id="hallName" name="hallName" value="<?php echo $row['hallName']; ?>" required>
        
        <label for="hallCapacity">Capacity:</label>
        <input type="number" id="hallCapacity" name="hallCapacity" value="<?php echo $row['hallCapacity']; ?>" required>
        
        <label for="hallLocation">Location:</label>
        <input type="text" id="hallLocation" name="hallLocation" value="<?php echo $row['hallLocation']; ?>" required>
        
        <label for="managerID">Manager ID:</label>
        <input type="text" id="managerID" name="managerID" value="<?php echo $row['managerID']; ?>" required>
        
        <label for="hallLayout">Upload Layout:</label>
        <input type="file" id="hallLayout" name="hallLayout" accept="image/*">
        
        <button type="submit" name="submit">Update Hall</button>
    </form>
</div>
</body>
</html>
