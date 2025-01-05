<?php

include "config.php"; 

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Payments</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
    }

    .container {
        display: flex;
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
        width: calc(100% - 220px); /* Adjust content width */
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search input {
        padding: 8px 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 200px;
    }

    .search button {
        padding: 8px 12px;
        border: none;
        background: #fdb827;
        color: black;
        border-radius: 5px;
        cursor: pointer;
    }

    .search button:hover {
        background-color: #e6a917;
    }

    .section-container {
        margin-top: 20px;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: #fdb827;
        color: black;
        text-decoration: none;
        border-radius: 5px;
        border: 1px solid #ddd;
        transition: background 0.3s, transform 0.2s;
    }

    .back-btn:hover {
        background-color: #e6a917;
        transform: scale(1.05);
    }

    .no-records {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #999;
        margin-top: 20px;
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
                <h1>Finance Management</h1>
            </header>

            <!-- Payments Section -->
            <section class="section-container">
                <h2>Payments made by customers</h2>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Amount Payable</th>
                                <th>Payment Date</th>
                                <th>Currency</th>
                                <th>Finance Manager ID</th>
                                <th>Customer ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM clientpayment"; 
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['paymentID']) . "</td>";
                                        echo "<td>" . htmlspecialchars(number_format($row['amountPayable'], 2)) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['paymentDate']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['currency']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['FmanagerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['clientID']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="financeM.php" class="back-btn">Back</a>
            </section>
        </main>
    </div>
</body>
</html>
