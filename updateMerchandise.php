<?php

include "config.php";

// Get merchandise ID from URL
$mID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $mID = intval($_POST['mID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pic = mysqli_real_escape_string($conn, $_POST['pic']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $onsale = mysqli_real_escape_string($conn, $_POST['onsale']);
    $des = mysqli_real_escape_string($conn, $_POST['des']);
    $cata = mysqli_real_escape_string($conn, $_POST['cata']);
    $managerid = intval($_POST['managerid']);
    $inventory = intval($_POST['inventory']);

    // Update query
    $sql = "UPDATE merchandise
            SET mName = '$name',
                productImg = '$pic',
                priceperU = '$price',
                qty = '$qty',
                onSale = '$onsale',
                mDes = '$des',
                productCategory = '$cata',
                managerID = $managerid,
                inventoryID = $inventory
            WHERE merchandiseID = $mID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageMerchandise.php';</script>";
        exit;
    } else {
        echo "Error updating merchandise: " . mysqli_error($conn);
    }
}

// Initialize merchandise details
$name = $pic = $price = $qty = $onsale = $des = $cata = $managerid = $inventory = "";

if ($mID > 0) {
    // Fetch merchandise details
    $sql2 = "SELECT * FROM merchandise WHERE merchandiseID = $mID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['mName'];
        $pic = $row['productImg'];
        $price = $row['priceperU'];
        $qty = $row['qty'];
        $onsale = $row['onSale'];
        $des = $row['mDes'];
        $cata = $row['productCategory'];
        $managerid = $row['managerID'];
        $inventory = $row['inventoryID'];

    } else {
        echo "<script>alert('Invalid Merchandise ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageMerchandise.php';</script>";
        exit;
    }
}

// Fetch manager IDs for the dropdown
$sql3 = "SELECT managerID FROM manager";
$result2 = mysqli_query($conn, $sql3);

// Fetch inventory IDs for the dropdown
$sql4 = "SELECT inventoryID FROM inventory";
$result3 = mysqli_query($conn, $sql4);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Merchandise</title>
    <link rel="stylesheet" type="text/css" href="updateFoodsup.css">
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
                        <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                        <li><a href="manageMerchandise.php" class="active2">Manage Merchandise</a></li>
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
            <div class="settings"><img src="Images/settings.png" alt="Settings">Settings</div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Merchandise Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png">
                    <button>Search</button>
                </div>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Update Merchandise</h2>
                    <form class="form" action="updateMerchandise.php" method="post">

                        <label for="id">Merchandise ID:</label>
                        <input type="text" name="mID" value="<?php echo htmlspecialchars($mID); ?>" readonly>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="pic">Picture:</label>
                        <input type="file" id="pic" name="pic" value="<?php echo htmlspecialchars($pic); ?>" accept="image/*">

                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>

                        <label for="qty">Quantity:</label>
                        <input type="text" id="qty" name="qty" value="<?php echo htmlspecialchars($qty); ?>" required>

                        <label for="onsale">On Sale:</label>
                        <select id="onsale" name="onsale" required>
                            <option value="yes" <?php if ($onsale == "yes") echo "selected"; ?>>Yes</option>
                            <option value="no" <?php if ($onsale == "no") echo "selected"; ?>>No</option>
                        </select><br>

                        <label for="des">Description:</label>
                        <input type="text" id="des" name="des" value="<?php echo htmlspecialchars($des); ?>" required>

                        <label for="cata">Product Category:</label>
                        <select id="cata" name="cata" required>
                            <option value="Clothing" <?php if ($cata == "Clothing") echo "selected"; ?>>Clothing</option>
                            <option value="Accessories" <?php if ($cata == "Accessories") echo "selected"; ?>>Accessories</option>
                            <option value="Toys" <?php if ($cata == "Toys") echo "selected"; ?>>Toys</option>
                            <option value="Stationery" <?php if ($cata == "Stationery") echo "selected"; ?>>Stationery</option>
                            <option value="Others" <?php if ($cata == "Others") echo "selected"; ?>>Others</option>
                        </select><br>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <option value="" disabled>Select Manager</option>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    $selected = ($row['managerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "' $selected>" . htmlspecialchars($row['managerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select><br>

                        <label for="inventory">Inventory ID:</label>
                        <select id="inventory" name="inventory" required>
                            <option value="" disabled>Select Inventory</option>
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = mysqli_fetch_assoc($result3)) {
                                    $selected = ($row['inventoryID'] == $inventory) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['inventoryID']) . "' $selected>" . htmlspecialchars($row['inventoryID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Inventories Available</option>";
                            }
                            ?>
                        </select><br>

                        <button class="sub-btn" type="submit" name="submit">Update Merchandise</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
