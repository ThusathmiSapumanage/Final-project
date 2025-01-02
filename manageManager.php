<?php
include 'config.php';

// Fetch all managers
$sqlManager = "SELECT * FROM manager";
$resultManager = mysqli_query($conn, $sqlManager);

$sqlHeadManager = "SELECT * FROM headmanager";
$resultHeadManager = mysqli_query($conn, $sqlHeadManager);

$sqlFinancialManager = "SELECT * FROM financialmanager";
$resultFinancialManager = mysqli_query($conn, $sqlFinancialManager);

$sqlEventManager = "SELECT * FROM eventmanager";
$resultEventManager = mysqli_query($conn, $sqlEventManager);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Managers</title>
    <link rel="stylesheet" href="manageFoodSup.css">
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <h1>Manage Managers</h1>

    <!-- General Manager Table -->
    <h2>All Managers</h2>
    <table class="table centered">
        <thead>
        <tr>
            <th>Manager ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($resultManager) > 0) {
            while ($row = mysqli_fetch_assoc($resultManager)) {
                echo "<tr>
                    <td>{$row['managerID']}</td>
                    <td>{$row['mName']}</td>
                    <td>{$row['mPhoneNumber']}</td>
                    <td>{$row['mEmail']}</td>
                    <td>{$row['mAddress']}</td>
                    <td class='actions'>
                        <a href='updateManager.php?id={$row['managerID']}' class='btn update-btn'>Update</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Head Manager Table -->
    <h2>Head Managers</h2>
    <table class="table centered">
        <thead>
        <tr>
            <th>Manager ID</th>
            <th>Department</th>
            <th>Team Size</th>
            <th>Authority Level</th>
            <th>Experience</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($resultHeadManager)) {
            echo "<tr>
                <td>{$row['HmanagerID']}</td>
                <td>{$row['departmentName']}</td>
                <td>{$row['teamSize']}</td>
                <td>{$row['authorityLevel']}</td>
                <td>{$row['yearsOfExperience']}</td>
            </tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Financial Manager Table -->
    <h2>Financial Managers</h2>
    <table class="table centered">
        <thead>
        <tr>
            <th>Manager ID</th>
            <th>Budget</th>
            <th>Tax ID</th>
            <th>Pending Payments</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($resultFinancialManager)) {
            echo "<tr>
                <td>{$row['FmanagerID']}</td>
                <td>{$row['managedBudget']}</td>
                <td>{$row['taxID']}</td>
                <td>{$row['pendingPayments']}</td>
            </tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Event Manager Table -->
    <h2>Event Managers</h2>
    <table class="table centered">
        <thead>
        <tr>
            <th>Manager ID</th>
            <th>Venue Incharge</th>
            <th>Events Handled</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($resultEventManager)) {
            echo "<tr>
                <td>{$row['EmanagerID']}</td>
                <td>{$row['venueIncharge']}</td>
                <td>{$row['eventTypesHandled']}</td>
            </tr>";
        }
        ?>
        </tbody>
    </table>

</div>
</body>
</html>
