<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $supplierID = $_POST['id']; // Use the ID provided by the user
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $suptype = $_POST['suptype'];
    $managerid = $_POST['managerid'];
    $bitems = $_POST['bitems'];
    $avgDeliveryTime = intval($_POST['avgDeliveryTime']);
    $minOrderSize = intval($_POST['minOrderSize']);

    // Check if the MySQL connection supports transactions
    if (mysqli_begin_transaction($conn)) {
        try {
            // Insert into `supplier` table
            $sql_supplier = "INSERT INTO supplier (supplierID, supplierName, supplierEmail, supplierPhone, supplierAddress, supType, HmanagerID) 
                             VALUES ('$supplierID', '$name', '$email', '$contact', '$address', '$suptype', '$managerid')";

            if (!mysqli_query($conn, $sql_supplier)) {
                throw new Exception("Error inserting into supplier: " . mysqli_error($conn));
            }

            // Insert into `beveragesupplier` table
            $sql_beveragesupplier = "INSERT INTO beveragesupplier (BsupplierID, bItems, averageDeliveryTime, minOrderSize) 
                                     VALUES ('$supplierID', '$bitems', '$avgDeliveryTime', '$minOrderSize')";

            if (!mysqli_query($conn, $sql_beveragesupplier)) {
                throw new Exception("Error inserting into beveragesupplier: " . mysqli_error($conn));
            }

            // Commit transaction
            mysqli_commit($conn);

            header("Location: manageFoodSup.php");
            exit;
        } catch (Exception $e) {
            // Rollback transaction on error
            if (mysqli_rollback($conn)) {
                echo "Transaction rolled back successfully.";
            }
            echo "Transaction failed: " . $e->getMessage();
        }
    } else {
        echo "Error: Transactions are not supported in your MySQL configuration.";
    }
}

// Fetch manager IDs from `headmanager` table
$sql = "SELECT HmanagerID FROM headmanager";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Food and Beverage Suppliers </title>
        <link rel="stylesheet" type="text/css" href="addcommon.css">
        <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
    }

    .container {
        display: flex;
    }

    .custom-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 200px; /* Sidebar width */
        background: #151515; /* Sidebar background color */
        color: white;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .custom-sidebar .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-sidebar .menu a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .custom-sidebar .menu a:hover,
    .custom-sidebar .menu a.active {
        background: #fdb827;
        color: black;
    }

    .main-content {
        margin-left: 220px; /* Sidebar width */
        padding: 20px;
        background-color: #ffffff; /* White background for content */
        width: 100%;
    }
    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: #fdb827;
        color: black;
        text-decoration: none;
        border-radius: 5px;
    }
</style>
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>
            
              <!-- Main Content -->
              <main class="content">
            <header class="header">
                <h1 style = 'color: white;'>Food Supplier Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Food and Beverage Supplier</h2>
                    <form class="form" action="addFoodsup.php" method="post">

                        <label for="id">Food supplier ID:</label>
                        <input type="text" id="id" name="id" value="FSID" required>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>

                        <label for="suptype">Supplier Type:</label>
                        <input type="text" id="suptype" name="suptype" value="Beverage supplier" readonly>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['HmanagerID'] . "'>" . $row['HmanagerID'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select>

                        <!-- Additional fields for beveragesupplier -->
                        <label for="bitems">Beverage Items:</label>
                        <input type="text" id="bitems" name="bitems" required>

                        <label for="avgDeliveryTime">Average Delivery Time (days):</label>
                        <input type="number" id="avgDeliveryTime" name="avgDeliveryTime" required>

                        <label for="minOrderSize">Minimum Order Size:</label>
                        <input type="number" id="minOrderSize" name="minOrderSize" required>

                        <button class="sub-btn" type="submit" name="submit">Add Supplier</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
