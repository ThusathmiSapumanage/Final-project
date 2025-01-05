<?php
include 'config.php';

// Initialize variables
$resourceID = $PstaffID = "";

// Fetch existing details
if (isset($_GET['resourceID']) && isset($_GET['PstaffID'])) {
    $resourceID = mysqli_real_escape_string($conn, $_GET['resourceID']);
    $PstaffID = mysqli_real_escape_string($conn, $_GET['PstaffID']);

    $sql = "SELECT * FROM photographerresources WHERE resourceID = '$resourceID' AND PstaffID = '$PstaffID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $resourceID = $row['resourceID'];
        $PstaffID = $row['PstaffID'];
    } else {
        echo "<script>alert('Invalid Resource Allocation. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageResources.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid Request. Redirecting back...');</script>";
    echo "<script>window.location.href = 'manageResources.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $newResourceID = mysqli_real_escape_string($conn, $_POST['resourceID']);
    $newPstaffID = mysqli_real_escape_string($conn, $_POST['PstaffID']);

    // Update query
    $sql = "UPDATE resource_allocation 
            SET resourceID = '$newResourceID', PstaffID = '$newPstaffID' 
            WHERE resourceID = '$resourceID' AND PstaffID = '$PstaffID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Resource allocation updated successfully!');</script>";
        echo "<script>window.location.href = 'manageResources.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating resource allocation: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Resource Allocation</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 50%;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    label {
        display: block;
        margin: 10px 0 5px;
        color: #555;
    }
    select {
        width: 100%;
        padding: 10px;
        margin: 5px 0 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .btn-update, .btn-back {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
    }
    .btn-update:hover, .btn-back:hover {
        background-color: #0056b3;
    }
    .btn-back {
        margin-top: 190px;
        background-color: #6c757d;
    }
    .btn-back:hover {
        background-color: #5a6268;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Update Resource Allocation</h1>
        <form action="" method="POST">
            <label for="resourceID">Resource ID:</label>
            <select id="resourceID" name="resourceID" required>
                <option value="">Select Resource ID</option>
                <?php
                $sql = "SELECT resourceID FROM resources";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['resourceID'] === $resourceID) ? 'selected' : '';
                        echo "<option value='" . $row['resourceID'] . "' $selected>" . $row['resourceID'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="PstaffID">Photographer Staff ID:</label>
            <select id="PstaffID" name="PstaffID" required>
                <option value="">Select Photographer Staff ID</option>
                <?php
                $sql = "SELECT PstaffID FROM photographer";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['PstaffID'] === $PstaffID) ? 'selected' : '';
                        echo "<option value='" . $row['PstaffID'] . "' $selected>" . $row['PstaffID'] . "</option>";
                    }
                }
                ?>
            </select>

            <button type="submit" name="submit" class="btn-update">Update</button>
        </form>
        <a href="manageresourceallo.php" class="btn-back">Back</a>
    </div>
</body>
</html>
