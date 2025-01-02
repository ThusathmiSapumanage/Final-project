<?php

include "config.php";

// Retrieve the `foodID` from the URL or form
$foodID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and fetch form inputs
    $foodID = intval($_POST['foodID']); // Match form field name
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $minOrder = intval($_POST['minOrder']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $moreInfo = mysqli_real_escape_string($conn, $_POST['moreInfo']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $supplierID = mysqli_real_escape_string($conn, $_POST['supplierID']);

    // Update query
    $sql = "UPDATE food
            SET foodName = '$name',
                foodPrice = '$price',
                minFoodOrder = '$minOrder',
                ingredients = '$ingredients',
                moreInfo = '$moreInfo',
                HmanagerID = '$managerID',
                BsupplierID = '$supplierID'
            WHERE foodID = $foodID";

    // Execute query and handle the result
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFood.php';</script>";
        exit;
    } else {
        echo "Error updating food item: " . mysqli_error($conn);
    }
}

// Fetch the current details of the food item for editing
$name = $price = $minOrder = $ingredients = $moreInfo = $managerID = $supplierID = "";
if ($foodID > 0) {
    $sql2 = "SELECT * FROM food WHERE foodID = $foodID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['foodName'];
        $price = $row['foodPrice'];
        $minOrder = $row['minFoodOrder'];
        $ingredients = $row['ingredients'];
        $moreInfo = $row['moreInfo'];
        $managerID = $row['HmanagerID'];
        $supplierID = $row['BsupplierID'];
    } else {
        echo "<script>alert('Invalid Item ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageFood.php';</script>";
        exit;
    }
}

$sql3 = "SELECT HmanagerID FROM headmanager";
$result2 = mysqli_query($conn, $sql3);

$sql4 = "SELECT BsupplierID FROM beveragesupplier";
$result3 = mysqli_query($conn, $sql4);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Food</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
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
                    <a href="supplierM.html" class="active">Supplies</a>
                    <ul class="dropdown-menu">
                        <li><a href="manageFood.php" class="active2">Manage Food</a></li>
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
                        <li><a href="expenseReports.php" class="active3">Expense Report</a></li>
                        <li><a href="incomeReport.php" class="active3">Income Report</a></li>
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
            <div class="settings"><img src="images/settings.png" alt="Settings">Settings</div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Food Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png" alt="Search">
                    <button>Search</button>
                </div>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Update Food</h2>
                    <form class="form" action="updateFood.php" method="post">
                        <label for="foodID">Food Item ID:</label>
                        <input type="text" id="foodID" name="foodID" value="<?php echo htmlspecialchars($foodID); ?>" readonly>

                        <label for="name">Item Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="price">Item Price:</label>
                        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>

                        <label for="minOrder">Minimum Order:</label>
                        <input type="number" id="minOrder" name="minOrder" value="<?php echo htmlspecialchars($minOrder); ?>" required>

                        <label for="ingredients">Ingredients:</label>
                        <input type="text" id="ingredients" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>" required>

                        <label for="moreInfo">More Info:</label>
                        <input type="text" id="moreInfo" name="moreInfo" value="<?php echo htmlspecialchars($moreInfo); ?>" required>

                        <label for="managerID">Manager ID:</label>
                        <select id="managerID" name="managerID" required>
                            <?php
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $selected = ($managerID == $row2['HmanagerID']) ? "selected" : "";
                                    echo "<option value='{$row2['HmanagerID']}' $selected>{$row2['HmanagerID']}</option>";
                                }
                            }
                            ?>
                        </select>

                        <label for="supplierID">Supplier ID:</label>
                        <select id="supplierID" name="supplierID" required>
                            <?php

                            if ($result3 && mysqli_num_rows($result3) > 0) {
                                while ($row3 = mysqli_fetch_assoc($result3)) {
                                    $selected = ($supplierID == $row3['BsupplierID']) ? "selected" : "";
                                    echo "<option value='{$row3['BsupplierID']}' $selected>{$row3['BsupplierID']}</option>";
                                }
                            }
                            ?>
                        </select>

                        <button class="sub-btn" type="submit" name="submit">Update Food</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
