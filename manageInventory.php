<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM inventory WHERE inventoryID = $id";
    mysqli_query($conn, $sql);
    echo "<script>alert('Supplier deleted successfully!'); window.location.href = 'manageInventory.php';</script>";
    echo "<script>window.location.href = 'manageInventory.php';</script>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Manage Inventories </title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Inventory Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>

                <!-- Suppliers Section -->
                <section class = "suppliers">
                    <h2>Inventories</h2>
                    <button class = "adding"><a href="addInventory.php">Add Inventory</a></button>
                    <div class="table1">
            <table class="table centered">
                <thead>
                    <tr>
                        <th>Inventory ID</th>
                        <th>Inventory Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM inventory";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['inventoryID'] . "</td>";
                            echo "<td>" . $row['inventoryDes'] . "</td>";
                            echo "<td class='actions'>
                                <a href='updateInventory.php?id=" . $row['inventoryID'] . "' class='btn update-btn'>Update</a>
                                <form action='' method='POST' style='display: inline;'>
                                    <input type='hidden' name='delete_id' value='" . $row['inventoryID'] . "'>
                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                </form>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No records found</td></tr>";
                    }

                    mysqli_close($conn);
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