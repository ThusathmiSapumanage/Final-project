<?php
include 'config.php';

// Delete functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $deleteID = $_POST['delete_id'];

    // Delete from receivediscount table
    $sqlDeleteReceived = "DELETE FROM receivediscount WHERE discountID = '$deleteID'";
    mysqli_query($conn, $sqlDeleteReceived);

    // Delete from managerdiscount table
    $sqlDeleteManager = "DELETE FROM managerdiscount WHERE discountID = '$deleteID'";
    mysqli_query($conn, $sqlDeleteManager);

    // Delete from generaldiscount if exists
    $sqlDeleteGeneral = "DELETE FROM generaldiscount WHERE GdiscountID = '$deleteID'";
    mysqli_query($conn, $sqlDeleteGeneral);

    // Delete from specialdiscount if exists
    $sqlDeleteSpecial = "DELETE FROM specialdiscount WHERE SdiscountID = '$deleteID'";
    mysqli_query($conn, $sqlDeleteSpecial);

    // Delete from discount table
    $sqlDeleteDiscount = "DELETE FROM discount WHERE discountID = '$deleteID'";
    if (mysqli_query($conn, $sqlDeleteDiscount)) {
        echo "<script>alert('Discount deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting discount: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch all discounts
$sqlDiscount = "SELECT * FROM discount";
$resultDiscount = mysqli_query($conn, $sqlDiscount);

// Fetch general discounts with additional fields
$sqlGeneralDiscount = "
    SELECT d.discountID, d.discountName, d.discountType, d.discountAmount, 
           g.minPaymentAmount, g.targetGroup, g.generalDreason
    FROM discount d
    INNER JOIN generaldiscount g ON d.discountID = g.GdiscountID";
$resultGeneralDiscount = mysqli_query($conn, $sqlGeneralDiscount);

// Fetch special discounts with additional fields
$sqlSpecialDiscount = "
    SELECT d.discountID, d.discountName, d.discountType, d.discountAmount, 
           s.eligibilityCriteria, s.validFrom, s.validTill, s.specialDReason
    FROM discount d
    INNER JOIN specialdiscount s ON d.discountID = s.SdiscountID";
$resultSpecialDiscount = mysqli_query($conn, $sqlSpecialDiscount);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Discounts</title>
    <link rel="stylesheet" href="managecommonstyles.css">
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
    }

    .container {
        display: flex;
    }

    .custom-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 200px; /* Sidebar width */
        background: #151515; /* Sidebar background color */
        color: white;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .custom-sidebar .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-sidebar .menu a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .custom-sidebar .menu a:hover,
    .custom-sidebar .menu a.active {
        background: #fdb827;
        color: black;
    }

    .main-content {
        margin-left: 220px; /* Sidebar width */
        padding: 20px;
        background-color: #ffffff; /* White background for content */
        width: 100%;
    }
</style>

</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <main class="main-content">
        <h1>Manage Discounts</h1>
        <a href="addDiscount.php" class="add-btn">Add Discount</a>

        <!-- General Discount Table -->
        <div class="table-container">
            <h2>General Discounts</h2>
            <table class="table centered">
                <thead>
                <tr>
                    <th>Discount ID</th>
                    <th>Discount Name</th>
                    <th>Discount Type</th>
                    <th>Discount Amount</th>
                    <th>Minimum Payment Amount</th>
                    <th>Target Group</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (mysqli_num_rows($resultGeneralDiscount) > 0) {
                    while ($row = mysqli_fetch_assoc($resultGeneralDiscount)) {
                        echo "<tr>
                            <td>{$row['discountID']}</td>
                            <td>{$row['discountName']}</td>
                            <td>{$row['discountType']}</td>
                            <td>{$row['discountAmount']}</td>
                            <td>{$row['minPaymentAmount']}</td>
                            <td>{$row['targetGroup']}</td>
                            <td>{$row['generalDreason']}</td>
                            <td class='actions'>
                                <a href='updateGdis.php?id={$row['discountID']}' class='btn update-btn'>Update</a>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='{$row['discountID']}'>
                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No general discounts found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Special Discount Table -->
        <div class="table-container">
            <h2>Special Discounts</h2>
            <table class="table centered">
                <thead>
                <tr>
                    <th>Discount ID</th>
                    <th>Discount Name</th>
                    <th>Discount Type</th>
                    <th>Discount Amount</th>
                    <th>Eligibility Criteria</th>
                    <th>Valid From</th>
                    <th>Valid Till</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (mysqli_num_rows($resultSpecialDiscount) > 0) {
                    while ($row = mysqli_fetch_assoc($resultSpecialDiscount)) {
                        echo "<tr>
                            <td>{$row['discountID']}</td>
                            <td>{$row['discountName']}</td>
                            <td>{$row['discountType']}</td>
                            <td>{$row['discountAmount']}</td>
                            <td>{$row['eligibilityCriteria']}</td>
                            <td>{$row['validFrom']}</td>
                            <td>{$row['validTill']}</td>
                            <td>{$row['specialDReason']}</td>
                            <td class='actions'>
                                <a href='updateSdis.php?id={$row['discountID']}' class='btn update-btn'>Update</a>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='{$row['discountID']}'>
                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No special discounts found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
