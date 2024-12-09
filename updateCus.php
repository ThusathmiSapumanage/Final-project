<?php

include "config.php";

// Get supplier ID from URL
$cusID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    
    $cusID = intval($_POST['cusID']); // Match name in form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $communication = mysqli_real_escape_string($conn, $_POST['communication']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update query
    $sql = "UPDATE cusprofile
            SET cName = '$name',
                cPhoneNumber = '$phone',
                communicationMethod = '$communication',
                companyName = '$company',
                cEmail = '$email'
            WHERE clientID = $cusID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageClient.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}

// Initialize supplier details
$name = $phone = $communication = $company = $email = "";

if ($cusID > 0) {
    // Fetch supplier details
    $sql2 = "SELECT * FROM cusprofile WHERE clientID = $cusID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['cName'];
        $phone = $row['cPhoneNumber'];
        $communication = $row['communicationMethod'];
        $company = $row['companyName'];
        $email = $row['cEmail'];

    } else {
        echo "<script>alert('Invalid Item ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageClient.php';</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Client </title>
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
                    <a href="#">Finance</a>
                    <div class="dropdown">
                        <a href="staffM.html">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active3">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="manageClient.php" class="active">Customer</a>
                    <a href="feedback.php">Feedback</a>
                </nav>
                <hr class="section-divider"> 
                <div class = "settings"><img src = Images/settings.png>Settings</div>
            </aside>
              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Customer Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Customer</h2>
                        <form class="form" action="updateCus.php" method="post">
                        
                        <label for = "cusID">Customer ID</label>	
                        <input type="text" id="cusID" name="cusID" value="<?php echo $cusID; ?>" readonly>

                        <label for = "name">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

                        <label for = "phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

                        <label for = "communication">Communication Method</label>
                        <select id="communication" name="communication" required>
                            <option value="Email" <?php if ($communication == "Email") echo "selected"; ?>>Email</option>
                            <option value="Phone" <?php if ($communication == "Call") echo "selected"; ?>>Call</option>
                            <option value="Phone" <?php if ($communication == "WhatsApp") echo "selected"; ?>>WhatsApp</option>
                            <option value="SMS" <?php if ($communication == "SMS") echo "selected"; ?>>SMS</option>
                        </select>

                        <label for = "company">Company Name</label>
                        <input type="text" id="company" name="company" value="<?php echo $company; ?>" required>

                        <label for = "email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                        
                        <button class = "sub-btn" type="submit" name="submit">Update Customer</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>