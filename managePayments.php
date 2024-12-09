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
        <aside class="sidebar">
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <nav class="menu">
            <div class="dropdown">
                        <a href="calendar.html">Events</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageAddon.php" class="active3">Manage Add-Ons</a></li>
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
                    <div class="dropdown">
                        <a href="financeM.html" class="active">Finance</a>
                        <ul class="dropdown-menu">
                        <li><a href="managePayments.php" class="active2">View Payments</a></li>
                        <li><a href="manageExpense.php" class="active3">View Expenses</a></li>
                        <li><a href="expensereport.html" class="active3">Expense & Income Chart and Report</a></li>
                        <li><a href="expenseReports.php" class = "active3">Expense Report</a></li>
                        <li><a href="incomeReport.php" class = "active3">Income Report</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="staffM.html">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active3">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="manageClient.php">Customer</a>
                    <a href="feedback.php">Feedback</a>
                </nav>
            <hr class="section-divider">
            <div class="settings"><img src="Images/settings.png">Settings</div>
        </aside>

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

            <!-- Suppliers Section -->
            <section class="suppliers">
                <h2>Payments made by customers</h2>
                <div class="table1">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Amount Payable</th>
                                <th>Payment Date</th>
                                <th>Customer ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM payment"; 
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['paymentID'] . "</td>";
                                        echo "<td>" . $row['amountPayable'] . "</td>";
                                        echo "<td>" . $row['paymentDate'] . "</td>";
                                        echo "<td>" . $row['clientID'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No records found</td></tr>";
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <a href="financeM.html"><button class = "back">Back</button></a>
            </section>
        </main>
    </div>
</body>
</html>