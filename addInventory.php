<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $des = $_POST['des'];

    $sql = "INSERT INTO inventory (inventoryDes) VALUES ('$des')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageInventory.php");
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
        <title> Add Inventories</title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

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
                        <h2>Add Inventory</h2>
                        <form class = "form" action="addInventory.php" method="post">

                            <label for="des">Description:</label>
                            <input type="text" id="des" name="des" required>

                            <button class = "sub-btn" type="submit" name="submit">Add Inventory</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>