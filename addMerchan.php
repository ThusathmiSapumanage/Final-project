<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $suptype = $_POST['suptype'];
    $managerid = $_POST['managerid'];

    $sql = "INSERT INTO supplier (supName, supEmail, supPhone, supAddress, supType, managerID) VALUES ('$name', '$email', '$contact', '$address', '$suptype', '$managerid')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageMerchan.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT managerID FROM manager";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Mercahndise Suppliers </title>
        <link rel="stylesheet" type="text/css" href="addMerchan.css">
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
                        <a href="supplierM.html" class="active">Supplies</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                            <li><a href="manageMerchandise.php" class="active3">Manage Merchandise</a></li>
                            <li><a href="manageFoodSup.php" class="active3">Manage Food Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active2">Manage Merchandise Supplier</a></li>
                            <li><a href="manageInventory.php" class="active3">Manage Inventory</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="financeM.html">Finance</a>
                        <ul class="dropdown-menu">
                            <li><a href="managePayments.php" class="active3">View Payments</a></li>
                            <li><a href="manageExpense.php" class="active3">View Expenses</a></li>
                            <li><a href="expensereport.html" class="active3">Expense & Income Chart and Report</a></li>
                        <li><a href="expenseReports.php">Expense Report</a></li>
                        <li><a href="incomeReport.php">Income Report</a></li>
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
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Merchandise Supplier Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Mercahndise Supplier</h2>
                        <form class = "form" action="addMerchan.php" method="post">

                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="contact">Contact:</label>
                            <input type="text" id="contact" name="contact" required>

                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required>

                            <label for="suptype">Supplier Type:</label>
                            <input type="text" id="suptype" name="suptype" value = "Merchandise supplier" readonly>

                            <label for="managerid">Manager ID:</label>
                            <select id="managerid" name="managerid">
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['managerID'] . "'>" . $row['managerID'] . "</option>";
                                    }
                                }
                                ?>
                                else
                                {
                                    echo "<option value='' disabled>No Managers Available</option>";
                                }
                                ?>
                            </select></br>
                            <button class = "sub-btn" type="submit" name="submit">Add Merchandise Supplier</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>