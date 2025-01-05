<?php

include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $pic = $_FILES['pic']['tmp_name']; // Handle file upload
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $onsale = $_POST['onsale'];
    $des = $_POST['des'];
    $cata = $_POST['cata'];
    $managerid = $_POST['managerid'];
    $inventory = $_POST['inventory'];
    $supplierid = $_POST['supplierid'];

    // Convert image to binary data
    $picContent = addslashes(file_get_contents($pic));

    // Insert into the merchandise table
    $sql = "INSERT INTO merchandise (productName, productImage, pricePerUnit, quantityInStock, isOnSale, productDescription, productCategory, EmanagerID, inventoryID, MsupplierID) 
            VALUES ('$name', '$picContent', '$price', '$qty', '$onsale', '$des', '$cata', '$managerid', '$inventory', '$supplierid')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Merchandise added successfully!');</script>";
        header("Location: manageMerchandise.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch manager IDs and Names
$sql = "SELECT managerID, mName FROM manager WHERE managerID LIKE 'EID%'";
$result = mysqli_query($conn, $sql);

// Fetch inventory IDs and Descriptions
$sql2 = "SELECT inventoryID, invetoryDescription FROM inventory";
$result2 = mysqli_query($conn, $sql2);

// Fetch supplier IDs and Items
$sql3 = "SELECT MsupplierID, mItems FROM merchandisesupplier";
$result3 = mysqli_query($conn, $sql3);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Merchandise</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1 style = 'color: white;'>Merchandise Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Merchandise</h2>
                    <form class="form" action="addMerchandise.php" method="post" enctype="multipart/form-data">
                        <label for="name">Merchandise Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter merchandise name" required>

                        <label for="pic">Picture:</label>
                        <input type="file" id="pic" name="pic" accept="image/*" required>

                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="Enter price" required>

                        <label for="qty">Quantity:</label>
                        <input type="number" id="qty" name="qty" placeholder="Enter quantity" required>

                        <label for="onsale">On Sale:</label><br>
                        <select id="onsale" name="onsale" required>
                            <option value="" disabled selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                        <label for="des">Item Description:</label>
                        <textarea id="des" name="des" placeholder="Enter item description" required></textarea>

                        <label for="cata">Product Category:</label>
                        <select id="cata" name="cata" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Toys">Toys</option>
                            <option value="Stationery">Stationery</option>
                            <option value="Others">Others</option>
                        </select>

                        <label for="managerid">Manager:</label>
                        <select id="managerid" name="managerid" required>
                            <option value="" disabled selected>Select Manager</option>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "'>" . htmlspecialchars($row['mName']) . " (ID: " . htmlspecialchars($row['managerID']) . ")</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select>

                        <label for="inventory">Inventory:</label>
                        <select id="inventory" name="inventory" required>
                            <option value="" disabled selected>Select Inventory</option>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    echo "<option value='" . htmlspecialchars($row['inventoryID']) . "'>" . htmlspecialchars($row['invetoryDescription']) . " (ID: " . htmlspecialchars($row['inventoryID']) . ")</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Inventories Available</option>";
                            }
                            ?>
                        </select>

                        <label for="supplierid">Supplier:</label>
                        <select id="supplierid" name="supplierid" required>
                            <option value="" disabled selected>Select Supplier</option>
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = mysqli_fetch_assoc($result3)) {
                                    echo "<option value='" . htmlspecialchars($row['MsupplierID']) . "'>" . htmlspecialchars($row['mItems']) . " (ID: " . htmlspecialchars($row['MsupplierID']) . ")</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Suppliers Available</option>";
                            }
                            ?>
                        </select>

                        <button class="sub-btn" type="submit" name="submit">Add Merchandise</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
