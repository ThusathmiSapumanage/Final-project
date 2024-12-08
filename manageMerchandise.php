<?php

include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM merchandise WHERE merchandiseID = $id";
    mysqli_query($conn, $sql);
    echo "<script>alert('update successs, redirecting to the view page...');</script>";
    echo "<script>window.location.href = 'manageMerchandise.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Merchandise Supplies</title>
    <link rel="stylesheet" type="text/css" href="viewmerchandise.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <nav class="menu">
                    <a href="calendar.html">Events</a>
                    <div class="dropdown">
                        <a href="supplierM.html" class="active">Supplies</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                            <li><a href="manageMerchandise.php" class="active2">Manage Merchandise</a></li>
                            <li><a href="manageFoodSup.php" class="active3">Manage Food Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active3">Manage Merchandise Supplier</a></li>
                        </ul>
                    </div>
                    <a href="#">Finance</a>
                    <div class="dropdown">
                        <a href="staffM.html">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active3">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="#">Client</a>
                    <a href="feedback.php">Feedback</a>
                </nav>
            <hr class="section-divider">
            <div class="settings"><img src="Images/settings.png">Settings</div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Merchandise Supply Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png">
                    <button>Search</button>
                </div>
            </header>

            <!-- Suppliers Section -->
            <section class="suppliers">
                <h2>Merchandise</h2>
                <button class = "adding"><a href="addMerchandise.php">Add Merchandise</a></button>
                <div class="table1">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Merchandise Name</th>
                                <th>Product Image</th>
                                <th>Price per</th>
                                <th>Qty</th>
                                <th>Date Added</th>
                                <th>On sale</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>ManagerID</th>
                                <th>InventoryID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM merchandise"; 
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['mName']) . "</td>";

                                        // Display image
                                        $imageData = base64_encode($row['productImg']);
                                        echo "<td><img src='data:image/jpeg;base64," . $imageData . "' alt='Product Image' style='width:100px; height:auto;'></td>";

                                        echo "<td>" . htmlspecialchars($row['priceperU']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['qty']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['dateAdded']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['onSale']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['mDes']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['productCategory']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['inventoryID']) . "</td>";
                                        echo "<td class='actions'>
                                                <a href='updateMerchandise.php?id=" . $row['merchandiseID'] . "' class='btn update-btn'>Update</a>
                                                <form action='' method='POST' style='display: inline;'>
                                                    <input type='hidden' name='delete_id' value='" . $row['merchandiseID'] . "'>
                                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                                </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11'>No records found</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <a href="supplierM.html"><button class = "back">Back</button></a>
            </section>
        </main>
    </div>
</body>
</html>