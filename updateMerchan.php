<?php
include "config.php";

// Get supplier ID from URL
$supID = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form inputs
    $supID = mysqli_real_escape_string($conn, $_POST['supID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $mlItems = mysqli_real_escape_string($conn, $_POST['mlItems']);
    $performance = mysqli_real_escape_string($conn, $_POST['performance']);
    $merchandiseCategory = mysqli_real_escape_string($conn, $_POST['merchandiseCategory']);

    // Update supplier table
    $sql_supplier = "UPDATE supplier 
                     SET supplierName = '$name', 
                         supplierEmail = '$email', 
                         supplierPhone = '$contact', 
                         supplierAddress = '$address', 
                         HmanagerID = '$managerid' 
                     WHERE supplierID = '$supID'";
    mysqli_query($conn, $sql_supplier);

    // Update merchandisesupplier table
    $sql_merchandise = "UPDATE merchandisesupplier 
                        SET mItems = '$mlItems', 
                            performance = '$performance', 
                            merchandiseCategory = '$merchandiseCategory' 
                        WHERE MsupplierID = '$supID'";
    mysqli_query($conn, $sql_merchandise);

    // Redirect after update
    echo "<script>alert('Update successful!'); window.location.href = 'manageMerchan.php';</script>";
    exit;
}

// Fetch supplier and merchandise details for the form
$name = $email = $contact = $address = $managerid = $mlItems = $performance = $merchandiseCategory = "";

if ($supID) {
    $sql_supplier = "SELECT * FROM supplier WHERE supplierID = '$supID'";
    $result_supplier = mysqli_query($conn, $sql_supplier);
    if ($row = mysqli_fetch_assoc($result_supplier)) {
        $name = $row['supplierName'];
        $email = $row['supplierEmail'];
        $contact = $row['supplierPhone'];
        $address = $row['supplierAddress'];
        $managerid = $row['HmanagerID'];
    }

    $sql_merchandise = "SELECT * FROM merchandisesupplier WHERE MsupplierID = '$supID'";
    $result_merchandise = mysqli_query($conn, $sql_merchandise);
    if ($row = mysqli_fetch_assoc($result_merchandise)) {
        $mlItems = $row['mItems'];
        $performance = $row['performance'];
        $merchandiseCategory = $row['merchandiseCategory'];
    }
}

// Fetch manager IDs for dropdown
$sql_managers = "SELECT HmanagerID FROM headmanager";
$result_managers = mysqli_query($conn, $sql_managers);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Merchandise Supplier</title>
    <link rel="stylesheet" type="text/css" href="addMerchan.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <main class="content">
            <header class="header">
                <h1>Update Merchandise Supplier</h1>
            </header>
            <div class="content-inner">
                <form class="form" action="updateMerchan.php" method="post">
                    <label for="id">Supplier ID:</label>
                    <input type="text" name="supID" value="<?php echo htmlspecialchars($supID); ?>" readonly>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

                    <label for="managerid">Manager ID:</label>
                    <select id="managerid" name="managerid" required>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_managers)) {
                            $selected = ($row['HmanagerID'] == $managerid) ? "selected" : "";
                            echo "<option value='" . htmlspecialchars($row['HmanagerID']) . "' $selected>" . htmlspecialchars($row['HmanagerID']) . "</option>";
                        }
                        ?>
                    </select><br>

                    <label for="mlItems">Merchandise Items:</label>
                    <input type="text" id="mlItems" name="mlItems" value="<?php echo htmlspecialchars($mlItems); ?>" required>

                    <label for="performance">Performance:</label>
                    <input type="text" id="performance" name="performance" value="<?php echo htmlspecialchars($performance); ?>" required>

                    <label for="merchandiseCategory">Merchandise Category:</label>
                    <input type="text" id="merchandiseCategory" name="merchandiseCategory" value="<?php echo htmlspecialchars($merchandiseCategory); ?>" required>

                    <button class="sub-btn" type="submit" name="submit">Update Supplier</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
