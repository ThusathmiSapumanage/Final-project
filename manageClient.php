<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $clientID = intval($_POST['delete_id']);

    // Delete associated discounts first
    $sql_delete_discounts = "DELETE FROM receivediscount WHERE clientID = $clientID";
    mysqli_query($conn, $sql_delete_discounts);

    // Delete customer
    $sql_delete_customer = "DELETE FROM client WHERE clientID = $clientID";
    if (mysqli_query($conn, $sql_delete_customer)) {
        echo "<script>alert('Customer deleted successfully!'); window.location.href = 'manageClient.php';</script>";
        exit;
    } else {
        echo "Error deleting customer: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
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
        .discount-btn
        {
            background-color: #4CAF50;
            cursor: pointer;
            border-radius: 5px;
        }
        .discount-btn a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Customer Management</h1>
            </header>

            <!-- Customers Section -->
            <section class="content-section">
                <h2>Customers</h2>
                <a href="addCus.php" class="btn add-btn">Add Customer</a>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Company Name</th>
                                <th>Communication Method</th>
                                <th>Contact Number</th>
                                <th>Password</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Manager ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM client";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['clientID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['clientname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['companyName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['communicationMethod']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cPhoneNumber']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['clientPass']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cDesignation']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cEmail']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                    echo "<td class='actions'>
                                        <a href='updateCus.php?id=" . htmlspecialchars($row['clientID']) . "' class='btn update-btn'>Update</a>
                                        <form action='' method='POST' style='display: inline;'>
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['clientID']) . "'>
                                            <button type='submit' class='btn delete-btn'>Delete</button>
                                        </form>
                                        <a href='reciveDiscount.php?clientID=" . htmlspecialchars($row['clientID']) . "' class='btn discount-btn'>Give Discount</a>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Received Discounts Section -->
            <section class="content-section">
                <h2>Customer Discounts</h2>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Discount ID</th>
                                <th>Discount Name</th>
                                <th>Discount Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT r.clientID, r.discountID, d.discountName, d.discountType 
                                    FROM receivediscount r
                                    JOIN discount d ON r.discountID = d.discountID";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['clientID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['discountID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['discountName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['discountType']) . "</td>";
                                    echo "<td class='actions'>
                                        <form action='' method='POST' style='display: inline;'>
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['clientID']) . "'>
                                            <input type='hidden' name='discount_id' value='" . htmlspecialchars($row['discountID']) . "'>
                                            <button type='submit' class='btn delete-btn'>Remove</button>
                                        </form>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No discounts found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
