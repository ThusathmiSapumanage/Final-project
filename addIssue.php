<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    $reportName = $_POST['reportName'];
    $reportType = $_POST['reportType'];
    $reportDes = $_POST['reportDes'];

    $sql = "INSERT INTO eventreport (reportName, reportType, reportDes) VALUES ('$reportName', '$reportType', '$reportDes')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageIssues.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Issue</title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
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
                        <a href="financeM.html">Finance</a>
                        <ul class="dropdown-menu">
                        <li><a href="managePayments.php" class="active3">View Payments</a></li>
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
                    <a href="manageIssues.php" class = "active">Report Issues</a>
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Reported Issue Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Issue</h2>
                        <form class = "form" action="addIssue.php" method="post">

                            <label for="reportName">Report Name</label>
                            <input type="text" id="reportName" name="reportName" required>

                            <label for="reportType">Report Type (Please select a type)</label>
                            <select id="reportType" name="reportType" required>
                                <option value="1">Technical</option>
                                <option value="2">Non-Technical</option>
                            </select></br>

                            <label for="reportDes">Report Description</label>
                            <input type="text" id="reportDes" name="reportDes" required>

                            <button class = "sub-btn" type="submit" name="submit">Add Issue</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>