<?php

include "config.php";

// Get supplier ID from URL
$supID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $supID = intval($_POST['supID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $suptype = mysqli_real_escape_string($conn, $_POST['suptype']);
    $managerid = intval($_POST['managerid']);

    // Update query
    $sql = "UPDATE supplier 
            SET supName = '$name', 
                supEmail = '$email', 
                supPhone = '$contact', 
                supAddress = '$address', 
                supType = '$suptype', 
                managerID = $managerid 
            WHERE supID = $supID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFoodSup.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$name = $email = $contact = $address = $suptype = $managerid = "";

if ($supID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM supplier WHERE supID = $supID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['supName'];
        $email = $row['supEmail'];
        $contact = $row['supPhone'];
        $address = $row['supAddress'];
        $suptype = $row['supType'];
        $managerid = $row['managerID'];
    }
}

// Fetch manager IDs for the dropdown
$sql3 = "SELECT managerID FROM manager";
$result2 = mysqli_query($conn, $sql3);
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Update Food and Beverage Suppliers </title>
        <link rel="stylesheet" type="text/css" href="updateFoodsup.css">
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
                            <li><a href="manageFoodSup.php" class="active2">Manage Food Supplier</a></li>
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
                    <a href="manageIssues.php">Report Issues</a>
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Food Supplier Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Food Supplier</h2>
                        <form class="form" action="updateFoodsup.php" method="post">
                        <label for="id">Supplier ID:</label>
                        <input type="text" name="supID" value="<?php echo htmlspecialchars($supID); ?>" readonly>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

                        <label for="suptype">Supplier Type:</label>
                        <input type="text" id="suptype" name="suptype" value="Food supplier" readonly>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    $selected = ($row['managerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "' $selected>" . htmlspecialchars($row['managerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select><br>
                        <button class="sub-btn" type="submit" name="submit">Update Food Supplier</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>