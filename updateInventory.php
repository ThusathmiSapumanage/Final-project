<?php

include "config.php";

// Get supplier ID from URL
$iID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $iID = intval($_POST['iID']);
    $des = mysqli_real_escape_string($conn, $_POST['des']);

    // Update query
    $sql = "UPDATE inventory
            SET inventoryDes = '$des' 
            WHERE inventoryID = $iID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageInventory.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$des = "";

if ($iID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM inventory WHERE inventoryID = $iID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $des = $row['inventoryDes'];
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Inventory </title>
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
                            <li><a href="managePayments.php" class="active3">Manage Payments</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="supplierM.html" class="active">Supplies</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                            <li><a href="manageMerchandise.php" class="active3">Manage Merchandise</a></li>
                            <li><a href="manageFoodSup.php" class="active3">Manage Food Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active3">Manage Merchandise Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active2">Manage Inventory</a></li>
                        </ul>
                    </div>
                    <a href="#">Finance</a>
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
                    <h1>Inventory Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Inventories</h2>
                        <form class="form" action="updateInventory.php" method="post">

                        <label for="id">Inventory ID:</label>
                        <input type="text" name="iID" value="<?php echo htmlspecialchars($iID); ?>" readonly>

                        <label for="name">Description:</label>
                        <input type="text" id="des" name="des" value="<?php echo htmlspecialchars($des); ?>" required>

                        <button class="sub-btn" type="submit" name="submit">Update Inventory</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>