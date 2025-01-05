<?php

include "config.php";

// Get inventory ID from the query parameter
$iID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $iID = intval($_POST['iID']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);

    // Update query
    $sql = "UPDATE inventory
            SET invetoryDescription = '$description', 
                EmanagerID = '$managerID'
            WHERE inventoryID = $iID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Inventory updated successfully. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageInventory.php';</script>";
        exit;
    } else {
        echo "Error updating inventory: " . mysqli_error($conn);
    }
}

// Fetch existing data for the selected inventory
$description = "";
$managerID = "";

if ($iID > 0) {
    $sql2 = "SELECT * FROM inventory WHERE inventoryID = $iID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $description = $row['invetoryDescription'];
        $managerID = $row['EmanagerID'];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Inventory</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">

        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1 style = 'color: white;'>Inventory Management</h1>
            </header>

            <div class="content-inner">
                <div class="content-box">
                    <h2>Update Inventory</h2>
                    <form class="form" action="updateInventory.php" method="post">

                        <label for="id">Inventory ID:</label>
                        <input type="text" name="iID" value="<?php echo htmlspecialchars($iID); ?>" readonly>

                        <label for="description">Description:</label>
                        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" required>

                        <label for="managerID">Manager ID:</label>
                        <select id="managerID" name="managerID" required>
                            <option value="">Select Manager ID</option>
                            <?php
                            $sql = "SELECT EmanagerID FROM eventmanager";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = $managerID == $row['EmanagerID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row['EmanagerID']) . "' $selected>" . htmlspecialchars($row['EmanagerID']) . "</option>";
                                }
                            }
                            ?>
                        </select>

                        <button class="sub-btn" type="submit" name="submit">Update Inventory</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
