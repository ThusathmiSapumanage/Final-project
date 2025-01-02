<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $pic = $_POST['pic'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $onsale = $_POST['onsale'];
    $des = $_POST['des'];
    $cata = $_POST['cata'];
    $managerid = $_POST['managerid'];
    $inventory = $_POST['inventory'];

    $sql = "INSERT INTO merchandise (mName, productImg, priceperU, qty, onSale, mDes, productCategory, managerID, inventoryID) VALUES ('$name', '$pic', '$price', '$qty', '$onsale', '$des', '$cata', '$managerid', '$inventory')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageMerchandise.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT managerID FROM manager";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT inventoryID FROM inventory";
$result2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Mercahndise</title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
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
                        <h2>Add Mercahndise</h2>
                        <form class = "form" action="addMerchandise.php" method="post">

                            <label for="name">Merchandise Name:</label>
                            <input type="text" id="name" name="name" required>

                            <label for="pic">Picture:</label>
                            <input type="file" id="pic" name="pic" accept="image/*" required>

                            <label for="price">Price:</label>
                            <input type="text" id="price" name="price" required>

                            <label for="qty">Quantity:</label>
                            <input type="text" id="qty" name="qty" required>

                            <label class="sale">On sale?</label></br>
                            <label class = "yes">Yes</label>
                            <input type="radio" name="yes" value="yes" />
                            <label class = "no">No</label>
                            <input type="radio" name="no" value="no" /></br>
                            
                            <label for="des">Item description:</label>
                            <input type="text" id="des" name="des" required>

                            <label for="cata">Product Category (Please select one):</label>
                            <select id="cata" name="cata" required>
                                <option value="Clothing">Clothing</option>
                                <option value="Accessories">Accessories</option>
                                <option value="Toys">Toys</option>
                                <option value="Stationery">Stationery</option>
                                <option value="Others">Others</option>
                            </select></br>

                            <label for="managerid">Manager ID:</label>
                            <select id="managerid" name="managerid">
                                <option value="" disabled selected>Select Manager</option>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['managerID'] . "'>" . $row['managerID'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No Managers Available</option>";
                                }
                                ?>
                            </select></br>

                            <label for="inventory">Inventory ID:</label>
                            <select id="inventory" name="inventory">
                                <option value="" disabled selected>Select Inventory</option>
                                <?php
                                if (mysqli_num_rows($result2) > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo "<option value='" . $row['inventoryID'] . "'>" . $row['inventoryID'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No Inventories Available</option>";
                                }
                                ?>
                            </select></br>
                            <button class = "sub-btn" type="submit" name="submit">Add Merchandise</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>