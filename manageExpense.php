<?php

include "config.php"; 

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Expenses</title>
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

            <!-- Expenses Section -->
            <section class="suppliers">
                <h2>Expenses at gapHQ</h2>
                <div class="table1">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Expense ID</th>
                                <th>Payment Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Paid Status</th>
                                <th>Head Manager ID</th>
                                <th>Finance Manager ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM expenses"; 
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['expenseID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['expensePaymentDate']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['expenseDescription']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['expenseType']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['expenseAmount']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['expensePaymentMethod']) . "</td>";
                                        echo "<td>" . ($row['expensePaidStatus'] ? 'Paid' : 'Not Paid') . "</td>";
                                        echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['FmanagerID']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>No records found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="financeM.html"><button class="back">Back</button></a>
            </section>
        </main>
    </div>
</body>
</html>
