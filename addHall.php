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
    <link rel="stylesheet" href="addcommon.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-inner">
            <h1>Add Hall</h1>
            <form action="addHall.php" method="POST" enctype="multipart/form-data" class="form">
                <label for="hallName">Hall Name:</label>
                <input type="text" id="hallName" name="hallName" required>
                
                <br>
                <label for="hallCapacity">Capacity:</label>
                <input type="number" id="hallCapacity" name="hallCapacity" required>
                
                <label for="hallLocation">Location:</label>
                <input type="text" id="hallLocation" name="hallLocation" required>
                
                <label for="managerID">Manager ID:</label>
                <select id="managerID" name="managerID" required>
                    <option value="">Select Manager</option>
                    <?php
                    $sqlManager = "SELECT managerID, mName FROM manager";
                    $resultManager = mysqli_query($conn, $sqlManager);

                    if (mysqli_num_rows($resultManager) > 0) {
                        while ($row = mysqli_fetch_assoc($resultManager)) {
                            echo "<option value='{$row['managerID']}'>{$row['mName']}</option>";
                        }
                    } else {
                        echo "<option value=''>No managers found</option>";
                    }
                    ?>
                </select>
                
                <label for="hallLayout">Upload Layout:</label>
                <input type="file" id="hallLayout" name="hallLayout" accept="image/*">
                
                <button type="submit" name="submit" class="sub-btn">Add Hall</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
