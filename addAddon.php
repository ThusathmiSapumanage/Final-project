<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $des = $_POST['des'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];

    $sql = "INSERT INTO addon (Amount, addOnPrice, description) VALUES ('$amount', '$price', '$des')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageAddon.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Add-Ons </title>
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
                    <h1>Event Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Add-Ons</h2>
                        <form class = "form" action="addAddon.php" method="post">
                           
                            <label for="des">Description</label>
                            <input type="text" id="des" name="des" required>

                            <label for="amount">Amount</label>
                            <input type="text" id="amount" name="amount" required>

                            <label for="price">Price per unit</label>
                            <input type="text" id="price" name="price" required>

                            <button class = "sub-btn" type="submit" name="submit">Add Add-On</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>