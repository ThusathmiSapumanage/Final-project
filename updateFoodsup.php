<?php

include "config.php";

// Get supplier ID from URL
$supplierID = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $supplierID = mysqli_real_escape_string($conn, $_POST['supplierID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $suptype = mysqli_real_escape_string($conn, $_POST['suptype']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $bitems = mysqli_real_escape_string($conn, $_POST['bitems']);
    $avgDeliveryTime = intval($_POST['avgDeliveryTime']);
    $minOrderSize = intval($_POST['minOrderSize']);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Update supplier table
        $sql_supplier = "UPDATE supplier 
                         SET supplierName = '$name', 
                             supplierEmail = '$email', 
                             supplierPhone = '$contact', 
                             supplierAddress = '$address', 
                             supType = '$suptype', 
                             HmanagerID = '$managerid' 
                         WHERE supplierID = '$supplierID'";

        if (!mysqli_query($conn, $sql_supplier)) {
            throw new Exception("Error updating supplier: " . mysqli_error($conn));
        }

        // Update beveragesupplier table
        $sql_beveragesupplier = "UPDATE beveragesupplier 
                                SET bItems = '$bitems', 
                                    averageDeliveryTime = $avgDeliveryTime, 
                                    minOrderSize = $minOrderSize 
                                WHERE BsupplierID = '$supplierID'";

        if (!mysqli_query($conn, $sql_beveragesupplier)) {
            throw new Exception("Error updating beveragesupplier: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);

        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFoodSup.php';</script>";
        exit;
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo "Error updating supplier: " . $e->getMessage();
    }
}

// Initialize supplier and beveragesupplier details
$name = $email = $contact = $address = $suptype = $managerid = $bitems = "";
$avgDeliveryTime = $minOrderSize = 0;

if (!empty($supplierID)) {
    // Fetch supplier details
    $sql2 = "SELECT supplierName, supplierEmail, supplierPhone, supplierAddress, supType, HmanagerID FROM supplier WHERE supplierID = '$supplierID'";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['supplierName'];
        $email = $row['supplierEmail'];
        $contact = $row['supplierPhone'];
        $address = $row['supplierAddress'];
        $managerid = $row['HmanagerID'];
    }

    // Fetch beveragesupplier details
    $sql3 = "SELECT * FROM beveragesupplier WHERE BsupplierID = '$supplierID'";
    $result2 = mysqli_query($conn, $sql3);

    if ($result2 && mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);
        $bitems = $row2['bItems'];
        $avgDeliveryTime = $row2['averageDeliveryTime'];
        $minOrderSize = $row2['minOrderSize'];
    }
}

// Fetch manager IDs for the dropdown
$sql4 = "SELECT managerID FROM manager";
$result3 = mysqli_query($conn, $sql4);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Food and Beverage Suppliers </title>
        <link rel="stylesheet" type="text/css" href="updateFoodsup.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Food and Beverage Supplier Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Food and Beverage Supplier</h2>
                        <form class="form" action="updateFoodsup.php" method="post">
                        <label for="id">Supplier ID:</label>
                        <input type="text" name="supplierID" value="<?php echo htmlspecialchars($supplierID); ?>" readonly>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

                        <label for="suptype">Supplier Type:</label>
                        <input type="text" id="suptype" name="suptype" value="Beverage supplier" readonly>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = $result3->fetch_assoc()) {
                                    $selected = ($row['managerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "' $selected>" . htmlspecialchars($row['managerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select>
                        
                        </br>
                        <!-- Beverage supplier specific fields -->
                        <label for="bitems">Beverage Items:</label>
                        <input type="text" id="bitems" name="bitems" value="<?php echo htmlspecialchars($bitems); ?>" required>

                        <label for="avgDeliveryTime">Average Delivery Time (days):</label>
                        <input type="number" id="avgDeliveryTime" name="avgDeliveryTime" value="<?php echo htmlspecialchars($avgDeliveryTime); ?>" required>

                        <label for="minOrderSize">Minimum Order Size:</label>
                        <input type="number" id="minOrderSize" name="minOrderSize" value="<?php echo htmlspecialchars($minOrderSize); ?>" required>

                        <button class="sub-btn" type="submit" name="submit">Update Supplier</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
