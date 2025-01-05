<?php
include "config.php";

// Get merchandise ID from URL
$mID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $mID = intval($_POST['mID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $onsale = mysqli_real_escape_string($conn, $_POST['onsale']);
    $des = mysqli_real_escape_string($conn, $_POST['des']);
    $cata = mysqli_real_escape_string($conn, $_POST['cata']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $inventory = mysqli_real_escape_string($conn, $_POST['inventory']);

    // Handle image upload
    $imageData = null;
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK) {
        $imageData = addslashes(file_get_contents($_FILES['pic']['tmp_name']));
    }

    // Update query
    $sql = "UPDATE merchandise
            SET productName = '$name',
                pricePerUnit = '$price',
                quantityInStock = '$qty',
                isOnSale = '$onsale',
                productDescription = '$des',
                productCategory = '$cata',
                EmanagerID = '$managerid',
                inventoryID = '$inventory'";

    // Add the image update only if a new file was uploaded
    if ($imageData) {
        $sql .= ", productImage = '$imageData'";
    }

    $sql .= " WHERE merchandiseID = $mID";

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
$name = $price = $qty = $onsale = $des = $cata = $managerid = $inventory = "";
$imagePreview = "";

if ($mID > 0) {
    // Fetch merchandise details
    $sql2 = "SELECT * FROM merchandise WHERE merchandiseID = $mID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['productName'];
        $price = $row['pricePerUnit'];
        $qty = $row['quantityInStock'];
        $onsale = $row['isOnSale'];
        $des = $row['productDescription'];
        $cata = $row['productCategory'];
        $managerid = $row['EmanagerID'];
        $inventory = $row['inventoryID'];
        $imagePreview = $row['productImage'];
    } else {
        echo "<script>alert('Invalid Merchandise ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageMerchandise.php';</script>";
        exit;
    }
}

// Fetch manager IDs for the dropdown
$sql3 = "SELECT EmanagerID FROM eventmanager";
$result2 = mysqli_query($conn, $sql3);

// Fetch inventory IDs for the dropdown
$sql4 = "SELECT inventoryID FROM inventory";
$result3 = mysqli_query($conn, $sql4);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Merchandise</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1 style = 'color: white;'>Merchandise Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Update Merchandise</h2>
                    <form class="form" action="updateMerchandise.php" method="post" enctype="multipart/form-data">

                        <label for="id">Merchandise ID:</label>
                        <input type="text" name="mID" value="<?php echo htmlspecialchars($mID); ?>" readonly>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="pic">Picture:</label>
                        <?php if ($imagePreview): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($imagePreview); ?>" alt="Product Image" style="width: 100px; height: auto;">
                        <?php endif; ?>
                        <input type="file" id="pic" name="pic" accept="image/*">

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
                                    $selected = ($row['EmanagerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['EmanagerID']) . "' $selected>" . htmlspecialchars($row['EmanagerID']) . "</option>";
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
