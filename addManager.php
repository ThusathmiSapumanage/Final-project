<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // General manager fields
    $managerID = $_POST['managerID'];
    $mPhoneNumber = $_POST['mPhoneNumber'];
    $mPassword = $_POST['mPassword'];
    $mName = $_POST['mName'];
    $mEmail = $_POST['mEmail'];
    $mAddress = $_POST['mAddress'];
    $managerType = $_POST['managerType'];

    // Insert into the `manager` table
    $sql = "INSERT INTO manager (managerID, mPhoneNumber, mPassword, mName, mEmail, mAddress) 
            VALUES ('$managerID', '$mPhoneNumber', '$mPassword', '$mName', '$mEmail', '$mAddress')";
    if (mysqli_query($conn, $sql)) {
        // Depending on the manager type, insert into the specific table
        switch ($managerType) {
            case "Head Manager":
                $departmentName = $_POST['departmentName'];
                $teamSize = $_POST['teamSize'];
                $authorityLevel = $_POST['authorityLevel'];
                $yearsOfExperience = $_POST['yearsOfExperience'];

                $headManagerSQL = "INSERT INTO headmanager (HmanagerID, departmentName, teamSize, authorityLevel, yearsOfExperience) 
                                   VALUES ('$managerID', '$departmentName', '$teamSize', '$authorityLevel', '$yearsOfExperience')";
                mysqli_query($conn, $headManagerSQL);
                break;

            case "Financial Manager":
                $managedBudget = $_POST['managedBudget'];
                $taxID = $_POST['taxID'];
                $pendingPayments = $_POST['pendingPayments'];

                $financialManagerSQL = "INSERT INTO financialmanager (FmanagerID, managedBudget, taxID, pendingPayments) 
                                        VALUES ('$managerID', '$managedBudget', '$taxID', '$pendingPayments')";
                mysqli_query($conn, $financialManagerSQL);
                break;

            case "Event Manager":
                $venueIncharge = $_POST['venueIncharge'];
                $eventTypesHandled = $_POST['eventTypesHandled'];

                $eventManagerSQL = "INSERT INTO eventmanager (EmanagerID, venueIncharge, eventTypesHandled) 
                                    VALUES ('$managerID', '$venueIncharge', '$eventTypesHandled')";
                mysqli_query($conn, $eventManagerSQL);
                break;
        }
        echo "<script>alert('Manager added successfully!'); window.location.href = 'manageManager.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Manager</title>
    <link rel="stylesheet" href="addFoodsup.css">
    <script>
        function showManagerSpecificFields() {
            const managerType = document.getElementById('managerType').value;
            document.getElementById('headManagerFields').style.display = managerType === 'Head Manager' ? 'block' : 'none';
            document.getElementById('financialManagerFields').style.display = managerType === 'Financial Manager' ? 'block' : 'none';
            document.getElementById('eventManagerFields').style.display = managerType === 'Event Manager' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <h1>Add Manager</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="managerID">Manager ID</label>
            <input type="text" id="managerID" name="managerID" required>
        </div>
        <div class="form-group">
            <label for="mPhoneNumber">Phone Number</label>
            <input type="text" id="mPhoneNumber" name="mPhoneNumber" required>
        </div>
        <div class="form-group">
            <label for="mPassword">Password</label>
            <input type="password" id="mPassword" name="mPassword" required>
        </div>
        <div class="form-group">
            <label for="mName">Name</label>
            <input type="text" id="mName" name="mName" required>
        </div>
        <div class="form-group">
            <label for="mEmail">Email</label>
            <input type="email" id="mEmail" name="mEmail" required>
        </div>
        <div class="form-group">
            <label for="mAddress">Address</label>
            <input type="text" id="mAddress" name="mAddress" required>
        </div>
        <div class="form-group">
            <label for="managerType">Manager Type</label>
            <select id="managerType" name="managerType" onchange="showManagerSpecificFields()" required>
                <option value="">Select Type</option>
                <option value="Head Manager">Head Manager</option>
                <option value="Financial Manager">Financial Manager</option>
                <option value="Event Manager">Event Manager</option>
            </select>
        </div>

        <!-- Head Manager Fields -->
        <div id="headManagerFields" style="display: none;">
            <h2>Head Manager Specific Fields</h2>
            <div class="form-group">
                <label for="departmentName">Department Name</label>
                <input type="text" id="departmentName" name="departmentName">
            </div>
            <div class="form-group">
                <label for="teamSize">Team Size</label>
                <input type="number" id="teamSize" name="teamSize">
            </div>
            <div class="form-group">
                <label for="authorityLevel">Authority Level</label>
                <input type="text" id="authorityLevel" name="authorityLevel">
            </div>
            <div class="form-group">
                <label for="yearsOfExperience">Years of Experience</label>
                <input type="number" id="yearsOfExperience" name="yearsOfExperience">
            </div>
        </div>

        <!-- Financial Manager Fields -->
        <div id="financialManagerFields" style="display: none;">
            <h2>Financial Manager Specific Fields</h2>
            <div class="form-group">
                <label for="managedBudget">Managed Budget</label>
                <input type="number" id="managedBudget" name="managedBudget" step="0.01">
            </div>
            <div class="form-group">
                <label for="taxID">Tax ID</label>
                <input type="text" id="taxID" name="taxID">
            </div>
            <div class="form-group">
                <label for="pendingPayments">Pending Payments</label>
                <input type="number" id="pendingPayments" name="pendingPayments">
            </div>
        </div>

        <!-- Event Manager Fields -->
        <div id="eventManagerFields" style="display: none;">
            <h2>Event Manager Specific Fields</h2>
            <div class="form-group">
                <label for="venueIncharge">Venue In Charge</label>
                <input type="text" id="venueIncharge" name="venueIncharge">
            </div>
            <div class="form-group">
                <label for="eventTypesHandled">Event Types Handled</label>
                <input type="text" id="eventTypesHandled" name="eventTypesHandled">
            </div>
        </div>

        <button type="submit" class="btn add-btn">Add Manager</button>
    </form>
</div>
</body>
</html>
