<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete from merchandisesupplier table
        $sql_merchandise = "DELETE FROM merchandisesupplier WHERE MsupplierID = '$id'";
        if (!mysqli_query($conn, $sql_merchandise)) {
            throw new Exception("Error deleting from merchandisesupplier: " . mysqli_error($conn));
        }

        // Delete from supplier table
        $sql_supplier = "DELETE FROM supplier WHERE supplierID = '$id'";
        if (!mysqli_query($conn, $sql_supplier)) {
            throw new Exception("Error deleting from supplier: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);

        echo "<script>alert('Supplier deleted successfully! Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageMerchan.php';</script>";
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
        <title> View Merchandise Suppliers </title>
        <link rel="stylesheet" type="text/css" href="viewmerchan.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Merchandise Supplier Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
                </header>

                <!-- Suppliers Section -->
                <section class="suppliers">
                    <h2>Merchandise Suppliers</h2>
                    <button class="adding"><a href="addMerchan.php">Add Merchandise Supplier</a></button>
                    <div class="table1">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Manager ID</th>
                                    <th>Merchandise Items</th>
                                    <th>Performance</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT s.supplierID, s.supplierName, s.supplierEmail, s.supplierPhone, s.supplierAddress, s.HmanagerID, 
                                                m.mItems, m.performance, m.merchandiseCategory 
                                        FROM supplier s 
                                        LEFT JOIN merchandisesupplier m ON s.supplierID = m.MsupplierID 
                                        WHERE s.supType = 'Merchandise supplier'";
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
                                        echo "<td>" . htmlspecialchars($row['mItems']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['performance']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['merchandiseCategory']) . "</td>";
                                        echo "<td class='actions'>
                                                <a href='updateMerchan.php?id=" . htmlspecialchars($row['supplierID']) . "' class='btn update-btn'>Update</a>
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
