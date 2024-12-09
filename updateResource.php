<?php

include "config.php";

$rID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rID = intval($_POST['rID']);
    $rname = mysqli_real_escape_string($conn, $_POST['rname']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $des = mysqli_real_escape_string($conn, $_POST['des']);
    $staffid = mysqli_real_escape_string($conn, $_POST['staffid']);

  
    $sql = "UPDATE resource
            SET resourceName = '$rname',
                availability = '$availability',
                description = '$des',
                staffID = '$staffid'
            WHERE resourceID = $rID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageResource.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

$name = $availability = $des = $staffid = "";

if ($rID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM resource WHERE resourceID = $rID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['resourceName'];
        $availability = $row['availability'];
        $des = $row['description'];
        $staffid = $row['staffID'];
    }
}

$sql3 = "SELECT staffID FROM staff";
$result2 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Resources </title>
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
                            <li><a href="manageMerchan.php" class="active2">Manage Inventory</a></li>
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
                    <a href="manageResource.php" class="active">Resource</a>
                    <a href="manageClient.php">Customer</a>
                    <a href="feedback.php">Feedback</a>
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Resource Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Resources</h2>
                        <form class="form" action="updateResource.php" method="post">

                        <input type="hidden" name="rID" value="<?php echo $rID; ?>">
                        <input type="text" name="rID" value="<?php echo htmlspecialchars($rID); ?>" readonly>

                        <label for="rname">Resource Name</label>
                        <input type="text" id="rname" name="rname" value="<?php echo $name; ?>" required>

                        <label for="availability">Availability</label>
                        <input type="date" id="availability" name="availability" value="<?php echo $availability; ?>" required>

                        <label for="des">Description</label>
                        <input type="text" id="des" name="des" value="<?php echo $des; ?>" required>

                        <label for="staffid">Staff ID</label>
                        <select id="staffid" name="staffid">
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    if ($staffid == $row2['staffID']) {
                                        echo "<option value='" . $row2['staffID'] . "' selected>" . $row2['staffID'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row2['staffID'] . "'>" . $row2['staffID'] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                        <button class="sub-btn" type="submit" name="submit">Update Resource</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>