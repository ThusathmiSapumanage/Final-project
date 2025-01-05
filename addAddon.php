<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $des = $_POST['des'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];
    $emanagerID = $_POST['emanagerID'];

    // Insert data into the addon table
    $sql = "INSERT INTO addon (amount, addonPrice, description, EmanagerID) 
            VALUES ('$amount', '$price', '$des', '$emanagerID')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageAddon.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Add-Ons</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Add-Ons</h2>
                    <form class="form" action="addAddon.php" method="post">
                        <label for="des">Description</label>
                        <input type="text" id="des" name="des" required>

                        <label for="amount">Quantity</label>
                        <input type="number" id="amount" name="amount" required>

                        <label for="price">Price per Unit (per hour)</label>
                        <input type="number" id="price" name="price" step="0.01" required>

                        <label for="emanagerID">Event Manager ID</label>
                        <select id="emanagerID" name="emanagerID">
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
                        <br>
                        
                        <button class="sub-btn" type="submit" name="submit">Add Add-On</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
