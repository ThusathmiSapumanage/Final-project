//CHECKEVERYTHING IN THIS MERCHANDISE SUPPLIER SHIT LATER

<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    // Collect and sanitize inputs
    $supplierID = mysqli_real_escape_string($conn, $_POST['supplierID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $mlItems = mysqli_real_escape_string($conn, $_POST['mlItems']);
    $performance = mysqli_real_escape_string($conn, $_POST['performance']);
    $merchandiseCategory = mysqli_real_escape_string($conn, $_POST['merchandiseCategory']);
    
    // Hardcoded supplier type
    $suptype = "Merchandise supplier";

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into the `supplier` table
        $sql_supplier = "INSERT INTO supplier (supplierID, supplierName, supplierEmail, supplierPhone, supplierAddress, supType, HmanagerID) 
                         VALUES ('$supplierID', '$name', '$email', '$contact', '$address', '$suptype', '$managerid')";

        if (!mysqli_query($conn, $sql_supplier)) {
            throw new Exception("Error inserting into supplier table: " . mysqli_error($conn));
        }

        // Insert into the `merchandisesupplier` table
        $sql_merchandisesupplier = "INSERT INTO merchandisesupplier (MsupplierID, mlItems, performance, merchandiseCategory) 
                                    VALUES ('$supplierID', '$mlItems', '$performance', '$merchandiseCategory')";

        if (!mysqli_query($conn, $sql_merchandisesupplier)) {
            throw new Exception("Error inserting into merchandisesupplier table: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);

        // Redirect on success
        echo "<script>alert('Merchandise Supplier added successfully!'); window.location.href = 'manageMerchan.php';</script>";
        exit;
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo "<script>alert('Transaction failed: " . $e->getMessage() . "');</script>";
    }
}

// Fetch manager IDs from the `headmanager` table
$sql = "SELECT HmanagerID FROM headmanager";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching manager IDs: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Merchandise Supplier</title>
    <link rel="stylesheet" type="text/css" href="addMerchan.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Merchandise Supplier Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="images/search-interface-symbol.png" alt="Search">
                    <button>Search</button>
                </div>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Merchandise Supplier</h2>
                    <form class="form" action="addMerchan.php" method="post">
                        <label for="supplierID">Supplier ID:</label>
                        <input type="text" id="supplierID" name="supplierID" placeholder="Enter unique ID" required>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['HmanagerID']) . "'>" . htmlspecialchars($row['HmanagerID']) . "</option>";
                            }
                            ?>
                        </select><br>

                        <label for="mlItems">Merchandise Items:</label>
                        <input type="text" id="mlItems" name="mlItems" required>

                        <label for="performance">Performance:</label>
                        <input type="text" id="performance" name="performance" required>

                        <label for="merchandiseCategory">Merchandise Category:</label>
                        <select id="merchandiseCategory" name="merchandiseCategory" required>
                            <option value="Apparel">Apparel</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Toys">Toys</option>
                            <option value="Stationery">Stationery</option>
                            <option value="Others">Others</option>
                        </select><br>
                        <button class="sub-btn" type="submit" name="submit">Add Merchandise Supplier</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
