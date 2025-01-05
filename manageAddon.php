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
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1>Manage Add-Ons</h1>
            <a href="addAddon.php" class="add-btn">Add Add-On</a>

            <!-- Add-Ons Section -->
            <div class="table-container">
                <h2>Add-Ons</h2>
                <table class="table">
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
        </div>
    </div>
</body>
</html>

