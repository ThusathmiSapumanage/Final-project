<?php
include "config.php";

// Initialize variables to avoid undefined warnings
$aID = $des = $amount = $price = $emanagerID = "";

// Retrieve `addonID` from GET or POST request
if (isset($_GET['id'])) {
    $aID = intval($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aID = intval($_POST['addonID']); // Ensure this matches the form input name
    $des = mysqli_real_escape_string($conn, $_POST['des']);
    $amount = intval($_POST['amount']);
    $price = floatval($_POST['price']);
    $emanagerID = mysqli_real_escape_string($conn, $_POST['emanagerID']);

    // Update query
    $sql = "UPDATE addon
            SET description = '$des',
                amount = $amount,
                addonPrice = $price,
                EmanagerID = '$emanagerID'
            WHERE addonID = $aID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageAddon.php';</script>";
        exit;
    } else {
        echo "Error updating add-on: " . mysqli_error($conn);
    }
}

if ($aID > 0) {
    // Fetch the add-on details
    $sql2 = "SELECT * FROM addon WHERE addonID = $aID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $des = $row['description'];
        $amount = $row['amount'];
        $price = $row['addonPrice'];
        $emanagerID = $row['EmanagerID'];
    } else {
        echo "<script>alert('Invalid Add-On ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageAddon.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Add-Ons</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Update Add-Ons</h1>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" action="updateAddon.php" method="post">

                        <label for="addonID">Add-On ID</label>
                        <input type="text" name="addonID" value="<?php echo htmlspecialchars($aID); ?>" readonly>

                        <label for="des">Description</label>
                        <input type="text" id="des" name="des" value="<?php echo htmlspecialchars($des); ?>" required>

                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" required>

                        <label for="price">Price Per Unit</label>
                        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" step="0.01" required>

                        <label for="emanagerID">Event Manager ID</label>
                        <select id="emanagerID" name="emanagerID">
                            <?php
                            $sql = "SELECT EmanagerID FROM eventmanager";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = ($row['EmanagerID'] === $emanagerID) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row['EmanagerID']) . "' $selected>" . htmlspecialchars($row['EmanagerID']) . "</option>";
                                }
                            }
                            ?>
                        </select>

                        <button class="sub-btn" type="submit" name="submit">Update Add-On</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
