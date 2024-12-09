<?php

include "config.php";

// Get supplier ID from URL
$tID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $tID = intval($_POST['taskID']);
    $taskdes = mysqli_real_escape_string($conn, $_POST['taskdes']);
    $due = mysqli_real_escape_string($conn, $_POST['due']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $staffid = mysqli_real_escape_string($conn, $_POST['staffid']);


    // Update query
    $sql = "UPDATE tasks
            SET taskDes = '$taskdes',
                taskDueDate = '$due',
                taskStatus = '$status',
                managerID = '$managerid',
                staffID = '$staffid'
                where taskID = $tID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageTasks.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$taskdes = $due = $status = $managerid = $staffid = "";

if ($tID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM tasks WHERE taskID = $tID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $taskdes = $row['taskDes'];
        $due = $row['taskDueDate'];
        $status = $row['taskStatus'];
        $managerid = $row['managerID'];
        $staffid = $row['staffID'];
    }
}

// Fetch manager IDs for the dropdown
$sql3 = "SELECT managerID FROM manager";
$result2 = mysqli_query($conn, $sql3);

$sql4 = "SELECT staffID FROM staff";
$result3 = mysqli_query($conn, $sql4);
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Update Tasks </title>
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
                            <li><a href="manageAddon.php" class="active2">Manage Add-Ons</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="supplierM.html" >Supplies</a>
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
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active2">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="#">Client</a>
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
                        <h2>Update Tasks</h2>
                        <form class="form" action="updateTask.php" method="post">

                            <label for="taskID">Task ID:</label>
                            <input type="text" id="taskID" name="taskID" value="<?php echo $tID; ?>" readonly>

                            <label for="taskdes">Task Description:</label>
                            <input type="text" id="taskdes" name="taskdes" value="<?php echo htmlspecialchars($taskdes); ?>" required>

                            <label for="due">Due Date:</label>
                            <input type="date" id="due" name="due" value="<?php echo htmlspecialchars($due); ?>" required>

                            <label for="status">Status:</label>
                            <select id="status" name="status">
                                <option value="Pending" <?php if ($status == "Pending") echo "selected"; ?>>Pending</option>
                                <option value="In Progress" <?php if ($status == "In Progress") echo "selected"; ?>>In Progress</option>
                                <option value="Completed" <?php if ($status == "Completed") echo "selected"; ?>>Completed</option>
                            </select>

                        <label for="manager">Manager ID:</label>
                        <select id="manager" name="managerid" required>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    $selected = ($row['managerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "' $selected>" . htmlspecialchars($row['managerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Manager Available</option>";
                            }
                            ?>
                        </select>

                        <label for = "staff">Staff ID:</label>
                        <select id="staff" name="staffid" required>
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = $result3->fetch_assoc()) {
                                    $selected = ($row['staffID'] == $staffid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['staffID']) . "' $selected>" . htmlspecialchars($row['staffID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Staff Available</option>";
                            }
                            ?>
                        </select>
                        <button class="sub-btn" type="submit" name="submit">Update Task</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>