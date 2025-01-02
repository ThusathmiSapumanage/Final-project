<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM addon WHERE addonID = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Addon deleted successfully! Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageAddon.php';</script>";
    } else {
        echo "Error deleting addon: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Add-Ons</title>
    <link rel="stylesheet" type="text/css" href="viewfood.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Manage Add-Ons</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png">
                    <button>Search</button>
                </div>
            </header>

            <!-- Add-Ons Section -->
            <section class="suppliers">
                <h2>Add-Ons</h2>
                <button class="adding"><a href="addAddon.php">Add Add-On</a></button>
                <div class="table1">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Add-On ID</th>
                                <th>Amount</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Event Manager ID</th>
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
            </section>
        </main>
    </div>
</body>
</html>
