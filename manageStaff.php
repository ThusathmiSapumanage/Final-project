<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM staff WHERE staffID = $id";
    mysqli_query($conn, $sql);
    echo "<script>alert('update successs, redirecting to the view page...');</script>";
    echo "<script>window.location.href = 'manageStaff.php';</script>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Manage Staff </title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <aside class = "sidebar">
                <div class="logo">
                    <img src="images/logo.png" alt="Logo">
                </div>
                <nav class="menu">
                <div class="dropdown">
                        <a href="calendar.html">Events</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageAddon.php" class="active3">Manage Add-Ons</a></li>
                            <li><a href="managePayments.php" class="active3">Manage Payments</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="supplierM.html">Supplies</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                            <li><a href="manageMerchandise.php" class="active3">Manage Merchandise</a></li>
                            <li><a href="manageFoodSup.php" class="active3">Manage Food Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active3">Manage Merchandise Supplier</a></li>
                            <li><a href="manageInventory.php" class="active3">Manage Inventory</a></li>
                        </ul>
                    </div>
                    <a href="#">Finance</a>
                    <div class="dropdown">
                        <a href="staffM.html" class="active">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active2">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active3">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="manageClient.php">Customer</a>
                    <a href="feedback.php">Feedback</a>
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Staff Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>

                <!-- Suppliers Section -->
                <section class = "suppliers">
                    <h2>Staff</h2>
                    <button class = "adding"><a href="addStaff.php">Add Staff Profile</a></button>
                    <div class="table1">
            <table class="table centered">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Availability</th>
                        <th>Name</th>
                        <th>UserID</th>
                        <th>Manager ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM staff";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['staffID'] . "</td>";
                            echo "<td>" . $row['staffAvailability'] . "</td>";
                            echo "<td>" . $row['staffName'] . "</td>";
                            echo "<td>" . $row['userID'] . "</td>";
                            echo "<td>" . $row['managerID'] . "</td>";
                            echo "<td class='actions'>
                                <a href='updateStaff.php?id=" . $row['staffID'] . "' class='btn update-btn'>Update</a>
                                <form action='' method='POST' style='display: inline;'>
                                    <input type='hidden' name='delete_id' value='" . $row['staffID'] . "'>
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
        <a href="staffM.html"><button class = "back">Back</button></a>
                </section>
            </main>
         </div>
    </body>
</html>