<?php

include "config.php";

// Get supplier ID from URL
$aID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    
    $aID = intval($_POST['addonID']); // Match name in form
    $des = mysqli_real_escape_string($conn, $_POST['des']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Update query
    $sql = "UPDATE addon
            SET description = '$des',
                Amount = '$amount',
                addOnPrice = '$price'
            WHERE addonID = $aID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageAddon.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$des = $amount = $price = "";

if ($aID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM addon WHERE addonID = $aID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $des = $row['description'];
        $amount = $row['Amount'];
        $price = $row['addOnPrice'];

    } else {
        echo "<script>alert('Invalid Item ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageAddon.php';</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Add-Ons </title>
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
                        <a href="calendar.html" class = "active">Events</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageAddon.php" class="active2">Manage Add-Ons</a></li>
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
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Event Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Add-Ons</h2>
                        <form class="form" action="updateAddon.php" method="post">

                            <label for="addonID">Add-On ID</label>
                            <input type="text" name="addonID" value="<?php echo htmlspecialchars($aID); ?>" readonly>

                            <label for="des">Description</label>
                            <input type="text" id="des" name="des" value="<?php echo $des; ?>" required>

                            <label for="amount">Amount</label>
                            <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required>

                            <label for="price">Price Per Unit</label>
                            <input type="text" id="price" name="price" value="<?php echo $price; ?>" required>

                        <button class = "sub-btn" type="submit" name="submit">Update Add-Ons</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>