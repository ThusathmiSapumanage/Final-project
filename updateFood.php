<?php

include "config.php";

// Get supplier ID from URL
$bID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    
    $bID = intval($_POST['bSupplierID']); // Match name in form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Update query
    $sql = "UPDATE beveragesup
            SET bItems = '$name',
                bItemPrice = '$price'
            WHERE bSupplierID = $bID"; 

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFood.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$name = $price = "";

if ($bID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM beveragesup WHERE bSupplierID = $bID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['bItems'];
        $price = $row['bItemPrice'];
    } else {
        echo "<script>alert('Invalid Item ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageFood.php';</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Food and Beverages </title>
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
                        <a href="financeM">Finance</a>
                        <ul class="dropdown-menu">
                            <li><a href="managePayments.php" class="active3">Manage Payments</a></li>
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
                    <h1>Food Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Food</h2>
                        <form class="form" action="updateFood.php" method="post">
                        <label for="id">Food Item ID:</label>
                        <input type="text" name="bSupplierID" value="<?php echo htmlspecialchars($bID); ?>" readonly>

                        <label for="name">Item Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="email">Item Price:</label>
                        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>

                        <button class = "sub-btn" type="submit" name="submit">Update Food</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>