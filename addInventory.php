<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Fetch form inputs
    $amount = intval($_POST['amount']);
    $addonPrice = floatval($_POST['addonPrice']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);

    // Insert query
    $sql = "INSERT INTO addon (amount, addonPrice, description, EmanagerID) 
            VALUES ('$amount', '$addonPrice', '$description', '$managerID')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageAddon.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Addon</title>
        <link rel="stylesheet" type="text/css" href="addAddon.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Addon Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
                </header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Addon</h2>
                        <form class="form" action="addAddon.php" method="post">

                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" required>

                            <label for="addonPrice">Addon Price:</label>
                            <input type="number" id="addonPrice" name="addonPrice" step="0.01" required>

                            <label for="description">Description:</label>
                            <input type="text" id="description" name="description" required>

                            <label for="managerID">Manager ID:</label>
                            <input type="text" id="managerID" name="managerID" required>

                            <button class="sub-btn" type="submit" name="submit">Add Addon</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
