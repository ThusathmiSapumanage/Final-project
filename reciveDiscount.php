<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);
    $discountID = mysqli_real_escape_string($conn, $_POST['discountID']);

    // Insert into the `recive discount` table
    $sql = "INSERT INTO receivediscount (clientID, discountID) VALUES ('$clientID', '$discountID')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Discount assigned successfully!'); window.location.href = 'manageClient.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch Client IDs and Discount IDs for dropdowns
$sql_clients = "SELECT clientID, clientname FROM client";
$sql_discounts = "SELECT discountID, discountName FROM discount";

$result_clients = mysqli_query($conn, $sql_clients);
$result_discounts = mysqli_query($conn, $sql_discounts);

if (!$result_clients || !$result_discounts) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receive Discount</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        .main-content {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Receive Discount</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Assign Discount to Customer</h2>
                    <form class="form" action="reciveDiscount.php" method="post">
                        <label for="clientID">Client:</label>
                        <select id="clientID" name="clientID" required>
                            <option value="" disabled selected>Select Client</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_clients)) {
                                echo "<option value='" . htmlspecialchars($row['clientID']) . "'>" . htmlspecialchars($row['clientname']) . "</option>";
                            }
                            ?>
                        </select>

                        <label for="discountID">Discount:</label>
                        <select id="discountID" name="discountID" required>
                            <option value="" disabled selected>Select Discount</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_discounts)) {
                                echo "<option value='" . htmlspecialchars($row['discountID']) . "'>" . htmlspecialchars($row['discountName']) . "</option>";
                            }
                            ?>
                        </select>

                        <button class="sub-btn" type="submit" name="submit">Assign Discount</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
