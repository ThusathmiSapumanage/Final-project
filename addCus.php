<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $communication = $_POST['communication'];
    $company = $_POST['company'];
    $email = $_POST['email'];

    $sql = "INSERT INTO cusprofile (cName, cPhoneNumber, communicationMethod, companyName, cEmail) VALUES ('$name', '$phone', '$communication', '$company', '$email')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageClient.php");
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
        <title> Add Customers </title>
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
                        <h2>Add Customers</h2>
                        <form class = "form" action="addCus.php" method="post">

                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required>

                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" required>

                            <label for="communication">Communication Method: (Please select one)</label>
                            <select id="communication" name="communication" required>
                                <option value="Email">Email</option>
                                <option value="Call">Call</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="SMS">SMS</option>
                            </select>

                            <label for="company">Company Name</label>
                            <input type="text" id="company" name="company" required>

                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>

                            <button class = "sub-btn" type="submit" name="submit">Add Customer</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>