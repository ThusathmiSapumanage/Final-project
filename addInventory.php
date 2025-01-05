<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Fetch form inputs
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);

    // Insert query for the inventory table
    $sql = "INSERT INTO inventory (invetoryDescription, EmanagerID) 
            VALUES ('$description', '$managerID')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageInventory.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Inventory</title>
        <link rel="stylesheet" type="text/css" href="addcommon.css">
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
                        <h2>Add Inventory</h2>
                        <form class="form" action="addInventory.php" method="post">

                            <label for="description">Inventory Description:</label>
                            <input type="text" id="description" name="description" required>

                            <label for="managerID">Manager ID:</label>
                            <select id="managerID" name="managerID" required>
                                <option value="">Select Manager ID</option>
                                <?php
                                $sql = "SELECT EmanagerID FROM eventmanager";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . htmlspecialchars($row['EmanagerID']) . "'>" . htmlspecialchars($row['EmanagerID']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <button class="sub-btn" type="submit" name="submit">Add Inventory</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
