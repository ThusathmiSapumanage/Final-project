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
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        .back-btn
        {
            background-color: #f44336;
            cursor: pointer;
        }
        .table-container
        {
            background: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1>Manage Managers</h1>
            <a href="addManager.php" class="add-btn">Add Manager</a>
            <button class="back-btn" onclick="window.location.href='staffM.php';">Back</button>

            <!-- General Manager Table -->
            <div class="table-container">
                <h2>All Managers</h2>
                <table class="table">
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
                        include 'config.php';
                        $sqlManager = "SELECT * FROM manager";
                        $resultManager = mysqli_query($conn, $sqlManager);

                        if (mysqli_num_rows($resultManager) > 0) {
                            while ($row = mysqli_fetch_assoc($resultManager)) {
                                echo "<tr>
                                    <td>{$row['managerID']}</td>
                                    <td>{$row['mName']}</td>
                                    <td>{$row['mPhoneNumber']}</td>
                                    <td>{$row['mEmail']}</td>
                                    <td>{$row['mAddress']}</td>
                                    <td class='actions'>
                                        <a href='updateManager.php?id={$row['managerID']}' class='update-btn'>Update</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Head Manager Table -->
            <div class="table-container">
                <h2>Head Managers</h2>
                <table class="table">
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
                        $sqlHeadManager = "SELECT * FROM headmanager";
                        $resultHeadManager = mysqli_query($conn, $sqlHeadManager);

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
            </div>

            <!-- Financial Manager Table -->
            <div class="table-container">
                <h2>Financial Managers</h2>
                <table class="table">
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
                        $sqlFinancialManager = "SELECT * FROM financialmanager";
                        $resultFinancialManager = mysqli_query($conn, $sqlFinancialManager);

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
            </div>

            <!-- Event Manager Table -->
            <div class="table-container">
                <h2>Event Managers</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Manager ID</th>
                            <th>Venue Incharge</th>
                            <th>Events Handled</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlEventManager = "SELECT * FROM eventmanager";
                        $resultEventManager = mysqli_query($conn, $sqlEventManager);

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
        </div>
    </div>
</body>
</html>
