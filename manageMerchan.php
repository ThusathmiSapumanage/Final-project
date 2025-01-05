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
        <title>View Merchandise Suppliers</title>
        <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
        <style>
        body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
        }

        .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        }

        .container {
        background-color: white;
        padding: 30px;
        margin-left: 300px;
        display: flex;
        }

        .table-container {
        background-color: white;
        width: 100%;	
        height: 100%;
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
                    <h1>Merchandise Supplier Management</h1>
                </header>

                <!-- Suppliers Section -->
                <section class="suppliers">
                    <h2>Merchandise Suppliers</h2>
                    <a href="addMerchansup.php" class="add-btn">Add Merchandise Supplier</a>
                    <div class="table-container">
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
                    <a href="supplierM.php" class="back-btn">Back</a>
                </section>
            </main>
        </div>
    </body>
</html>
