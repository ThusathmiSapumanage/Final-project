<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize input
    $foodName = mysqli_real_escape_string($conn, $_POST['foodName']);
    $foodPrice = mysqli_real_escape_string($conn, $_POST['foodPrice']);
    $minFoodOrder = mysqli_real_escape_string($conn, $_POST['minFoodOrder']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $moreInfo = mysqli_real_escape_string($conn, $_POST['moreInfo']);
    $hmanagerID = mysqli_real_escape_string($conn, $_POST['hmanagerID']);
    $bsupplierID = mysqli_real_escape_string($conn, $_POST['bsupplierID']);

    // Insert into `food` table
    $sql = "INSERT INTO food (foodName, foodPrice, minFoodOrder, ingredients, moreInfo, HmanagerID, BsupplierID) 
            VALUES ('$foodName', '$foodPrice', '$minFoodOrder', '$ingredients', '$moreInfo', '$hmanagerID', '$bsupplierID')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Food item added successfully!'); window.location.href = 'manageFood.php';</script>";
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch `HmanagerID` and `BsupplierID` for dropdowns
$sql_managers = "SELECT HmanagerID FROM headmanager";
$sql_suppliers = "SELECT BsupplierID FROM beveragesupplier";

$result_managers = mysqli_query($conn, $sql_managers);
$result_suppliers = mysqli_query($conn, $sql_suppliers);

if (!$result_managers || !$result_suppliers) {
    die("Error fetching manager or supplier IDs: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Food</title>
        <link rel="stylesheet" type="text/css" href="addcommon.css">
        <style>
            .content-box {
                background-color: white;
            }

            .main-content
            {
                background-color: white;
            }
            .actions
            {
                gap: 0px;
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
                    <h1>Food Management</h1>
                </header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Food</h2>
                        <form class="form" action="addFood.php" method="post">
                            <label for="foodName">Food Name:</label>
                            <input type="text" id="foodName" name="foodName" required>

                            <label for="foodPrice">Food Price:</label>
                            <input type="number" id="foodPrice" name="foodPrice" step="0.01" required>

                            <label for="minFoodOrder">Minimum Order:</label>
                            <input type="number" id="minFoodOrder" name="minFoodOrder" required>

                            <label for="ingredients">Ingredients:</label>
                            <textarea id="ingredients" name="ingredients" required></textarea>

                            <label for="moreInfo">More Info:</label>
                            <textarea id="moreInfo" name="moreInfo"></textarea>

                            <label for="hmanagerID">Manager ID:</label>
                            <select id="hmanagerID" name="hmanagerID" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_managers)) {
                                    echo "<option value='" . htmlspecialchars($row['HmanagerID']) . "'>" . htmlspecialchars($row['HmanagerID']) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="bsupplierID">Supplier ID:</label>
                            <select id="bsupplierID" name="bsupplierID" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_suppliers)) {
                                    echo "<option value='" . htmlspecialchars($row['BsupplierID']) . "'>" . htmlspecialchars($row['BsupplierID']) . "</option>";
                                }
                                ?>
                            </select>

                            <button class="sub-btn" type="submit" name="submit">Add Food</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
