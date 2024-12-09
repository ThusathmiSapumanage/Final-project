<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $taskdes = $_POST['taskdes'];
    $due = $_POST['due'];
    $status = $_POST['status'];
    $managerid = $_POST['managerid'];
    $staffid = $_POST['staffid'];

    $sql = "INSERT INTO tasks (taskDes, taskDueDate, taskStatus, managerID, staffID) VALUES ('$taskdes', '$due', '$status', '$managerid', '$staffid')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageTasks.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT managerID FROM manager";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT staffID FROM staff";
$result2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Task</title>
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
                        <li><a href="expenseReports.php">Expense Report</a></li>
                        <li><a href="incomeReport.php">Income Report</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="staffM.html" class="active">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active2">Manage Tasks</a></li>
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
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Tasks</h2>
                        <form class = "form" action="addTask.php" method="post">

                            <label for="taskdes">Task Description:</label>
                            <input type="text" id="taskdes" name="taskdes" required>

                            <label for="due">Task Due date:</label>
                            <input type="date" id="due" name="due" required>

                            <label for="status">Status:</label>
                            <select id="status" name="status">
                                <option value="" disabled selected>Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select><br>

                            <label for="managerid">Manager ID:</label>
                            <select id="managerid" name="managerid">
                                <option value="" disabled selected>Select Manager</option>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['managerID'] . "'>" . $row['managerID'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No Managers Available</option>";
                                }
                                ?>
                            </select><br>

                            <label for="staff">Staff ID:</label>
                            <select id="staffid" name="staffid">
                                <option value="" disabled selected>Select Staff ID</option>
                                <?php
                                if (mysqli_num_rows($result2) > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo "<option value='" . $row['staffID'] . "'>" . $row['staffID'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No staff available</option>";
                                }
                                ?>
                            </select><br>
                            <button class = "sub-btn" type="submit" name="submit">Add Task</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>