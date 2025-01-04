<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM addon WHERE addonID = $id";
    mysqli_query($conn, $sql);
    echo "<script>alert('Addon deleted successfully!'); window.location.href = 'manageAddon.php';</script>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Addons</title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
    </head>
    <body>
        <div class="container">
            <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Addon Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
                </header>

                <!-- Addon Section -->
                <section class="addons">
                    <h2>Addons</h2>
                    <button class="adding"><a href="addAddon.php">Add Addon</a></button>
                    <div class="table1">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Addon ID</th>
                                    <th>Amount</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Manager ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM addon";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['addonID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['addonPrice']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['EmanagerID']) . "</td>";
                                        echo "<td class='actions'>
                                            <a href='updateAddon.php?id=" . htmlspecialchars($row['addonID']) . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['addonID']) . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                          </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                }

                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="manageAddon.php"><button class="back">Back</button></a>
                </section>
            </main>
        </div>
    </body>
</html>
