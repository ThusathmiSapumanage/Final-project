<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM inventory WHERE inventoryID = $id";
    mysqli_query($conn, $sql);
    echo "<script>alert('Inventory deleted successfully!'); window.location.href = 'manageInventory.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory</title>
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
        margin-left: 220px; /* Adjusted to match sidebar width */
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        }

        .table-container {
        background-color: white;
        width: 80%;
        padding: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 20px;
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
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Inventory Management</h1>
            </header>

            <!-- Inventory Section -->
            <section class="inventory">
                <h2>Inventory</h2>
                <a href="addInventory.php" class="add-btn">Add Inventory</a>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Inventory ID</th>
                                <th>Inventory Description</th>
                                <th>Manager ID</th>
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
                                    echo "<td>" . htmlspecialchars($row['inventoryID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['invetoryDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['EmanagerID']) . "</td>";
                                    echo "<td class='actions'>
                                        <a href='updateInventory.php?id=" . htmlspecialchars($row['inventoryID']) . "' class='btn update-btn'>Update</a>
                                        <form action='' method='POST' style='display: inline;'>
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['inventoryID']) . "'>
                                            <button type='submit' class='btn delete-btn'>Delete</button>
                                        </form>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No records found</td></tr>";
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
