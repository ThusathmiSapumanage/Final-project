<?php

include "config.php"; 

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Payments</title>
    <link rel="stylesheet" type="text/css" href="manageFoodSup.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Finance Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png">
                    <button>Search</button>
                </div>
            </header>

            <!-- Payments Section -->
            <section class="payments">
                <h2>Payments made by customers</h2>
                <div class="table1">
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
                <a href="financeM.php"><button class="back">Back</button></a>
            </section>
        </main>
    </div>
</body>
</html>
