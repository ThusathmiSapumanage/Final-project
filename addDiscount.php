<?php
include 'config.php';

// Get the client ID from the URL
if (isset($_GET['clientID'])) {
    $clientID = intval($_GET['clientID']);
} else {
    echo "<script>alert('No client selected.'); window.location.href = 'manageClient.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discountID = intval($_POST['discountID']);

    // Insert into clientdiscount table
    $sql = "INSERT INTO clientdiscount (clientID, dID) VALUES ($clientID, $discountID)";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Discount successfully assigned!'); window.location.href = 'manageClient.php';</script>";
    } else {
        echo "<script>alert('Error assigning discount: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Discount</title>
    <link rel="stylesheet" type="text/css" href="formStyles.css">
</head>
<body>
    <div class="form-container">
        <h1>Assign Discount</h1>
        <form action="" method="POST">
            <label for="clientID">Client ID:</label>
            <input type="text" name="clientID" id="clientID" value="<?php echo $clientID; ?>" readonly>

            <label for="discountID">Select Discount:</label>
            <select name="discountID" id="discountID" required>
                <?php
                $discountQuery = "SELECT * FROM discount";
                $discountResult = mysqli_query($conn, $discountQuery);
                while ($discountRow = mysqli_fetch_assoc($discountResult)) {
                    echo "<option value='" . $discountRow['dID'] . "'>" . $discountRow['dName'] . " (" . $discountRow['dType'] . ")</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn submit-btn">Assign Discount</button>
            <a href="manageClient.php" class="btn cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
