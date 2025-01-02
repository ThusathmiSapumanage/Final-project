<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete from beveragesupplier table
        $sql_beverage = "DELETE FROM beveragesupplier WHERE BsupplierID = '$id'";
        if (!mysqli_query($conn, $sql_beverage)) {
            throw new Exception("Error deleting from beveragesupplier: " . mysqli_error($conn));
        }

        // Delete from supplier table
        $sql_supplier = "DELETE FROM supplier WHERE supplierID = '$id'";
        if (!mysqli_query($conn, $sql_supplier)) {
            throw new Exception("Error deleting from supplier: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);

        echo "<script>alert('Supplier deleted successfully! Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFoodSup.php';</script>";
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo "<script>alert('Error deleting supplier: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Manage Food and Beverage Suppliers </title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Food and Beverage Supplier Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
                </header>

                <!-- Suppliers Section -->
                <section class="suppliers">
                    <h2>Suppliers</h2>
                    <button class="adding"><a href="addFoodsup.php">Add Supplier</a></button>
                    <div class="table1">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Manager ID</th>
                                    <th>Items</th>
                                    <th>Delivery Time</th>
                                    <th>Minimum Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT s.supplierID, s.supplierName, s.supplierEmail, s.supplierPhone, s.supplierAddress, s.HmanagerID, 
                                                b.bItems, b.averageDeliveryTime, b.minOrderSize 
                                        FROM supplier s 
                                        LEFT JOIN beveragesupplier b ON s.supplierID = b.BsupplierID";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['supplierID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['supplierName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['supplierEmail']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['supplierPhone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['supplierAddress']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['bItems']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['averageDeliveryTime']) . " days</td>";
                                        echo "<td>" . htmlspecialchars($row['minOrderSize']) . "</td>";
                                        echo "<td class='actions'>
                                                <a href='updateFoodSup.php?id=" . htmlspecialchars($row['supplierID']) . "' class='btn update-btn'>Update</a>
                                                <form action='' method='POST' style='display: inline;'>
                                                    <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['supplierID']) . "'>
                                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>No records found</td></tr>";
                                }

                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="supplierM.html"><button class="back">Back</button></a>
                </section>
            </main>
         </div>
    </body>
</html>
