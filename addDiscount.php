<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $discountID = mysqli_real_escape_string($conn, $_POST['discountID']);
    $discountName = mysqli_real_escape_string($conn, $_POST['discountName']);
    $discountType = mysqli_real_escape_string($conn, $_POST['discountType']);
    $discountAmount = mysqli_real_escape_string($conn, $_POST['discountAmount']);
    $emanagerID = mysqli_real_escape_string($conn, $_POST['emanagerID']);

    // Save basic discount details in the discount table
    $sql = "INSERT INTO discount (discountID, discountName, discountType, discountAmount) 
            VALUES ('$discountID', '$discountName', '$discountType', '$discountAmount')";
    
    if (mysqli_query($conn, $sql)) {
        // Save discount to the managerdiscount table
        $managerSql = "INSERT INTO managerdiscount (EmanagerID, discountID) VALUES ('$emanagerID', '$discountID')";
        mysqli_query($conn, $managerSql);

        // Redirect to the appropriate form
        if ($discountType == "General") {
            header("Location: addGeneraldis.php?discountID=$discountID");
        } elseif ($discountType == "Special") {
            header("Location: addSpecialdis.php?discountID=$discountID");
        }
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch Event Manager IDs for dropdown
$sql_emanager = "SELECT EmanagerID FROM eventmanager";
$result_emanager = mysqli_query($conn, $sql_emanager);

if (!$result_emanager) {
    die("Error fetching Event Manager IDs: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Discount</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        .main-content {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php';?>
        <main class="main-content">
            <header class="header">
                <h1>Add Discount</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" action="addDiscount.php" method="post">
                        <label for="discountID">Discount ID:</label>
                        <input type="text" id="discountID" name="discountID" placeholder="SD for special discount and GD for general discount" required>
                        <small style="color: black;">Example: SD001 or GD001</small>
                        <br>
                        <br>

                        <label for="discountName">Discount Name:</label>
                        <input type="text" id="discountName" name="discountName" required>

                        <label for="discountType">Discount Type:</label>
                        <select id="discountType" name="discountType" required>
                            <option value="General">General</option>
                            <option value="Special">Special</option>
                        </select>
                        <br>

                        <label for="discountAmount">Discount Amount:</label>
                        <input type="number" id="discountAmount" name="discountAmount" step="0.01" required>

                        <label for="emanagerID">Event Manager ID:</label>
                        <select id="emanagerID" name="emanagerID" required>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_emanager)) {
                                echo "<option value='" . htmlspecialchars($row['EmanagerID']) . "'>" . htmlspecialchars($row['EmanagerID']) . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <br>

                        <button class="sub-btn" type="submit" name="submit">Add Discount</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
