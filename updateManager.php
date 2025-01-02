<?php
include 'config.php'; // Include your database connection

// Check if a manager ID is provided
if (isset($_GET['id'])) {
    $managerID = $_GET['id'];

    // Fetch manager data
    $managerSql = "SELECT * FROM manager WHERE managerID = '$managerID'";
    $managerResult = mysqli_query($conn, $managerSql);
    $managerData = mysqli_fetch_assoc($managerResult);

    if (!$managerData) {
        die("Manager not found!");
    }

    // Determine the type of manager (Head, Financial, Event)
    $managerType = null;
    $typeSpecificData = [];

    if ($managerTypeResult = mysqli_query($conn, "SELECT * FROM headmanager WHERE HmanagerID = '$managerID'")) {
        if (mysqli_num_rows($managerTypeResult) > 0) {
            $managerType = 'Head';
            $typeSpecificData = mysqli_fetch_assoc($managerTypeResult);
        }
    }
    if (!$managerType && $managerTypeResult = mysqli_query($conn, "SELECT * FROM financialmanager WHERE FmanagerID = '$managerID'")) {
        if (mysqli_num_rows($managerTypeResult) > 0) {
            $managerType = 'Financial';
            $typeSpecificData = mysqli_fetch_assoc($managerTypeResult);
        }
    }
    if (!$managerType && $managerTypeResult = mysqli_query($conn, "SELECT * FROM eventmanager WHERE EmanagerID = '$managerID'")) {
        if (mysqli_num_rows($managerTypeResult) > 0) {
            $managerType = 'Event';
            $typeSpecificData = mysqli_fetch_assoc($managerTypeResult);
        }
    }

    if (!$managerType) {
        die("Manager type not found!");
    }
} else {
    die("Manager ID is required!");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Update shared manager fields
    $mName = mysqli_real_escape_string($conn, $_POST['mName']);
    $mEmail = mysqli_real_escape_string($conn, $_POST['mEmail']);
    $mPhoneNumber = mysqli_real_escape_string($conn, $_POST['mPhoneNumber']);
    $mAddress = mysqli_real_escape_string($conn, $_POST['mAddress']);
    $mPassword = mysqli_real_escape_string($conn, $_POST['mPassword']);

    $updateManagerSql = "
        UPDATE manager 
        SET mName = '$mName', mEmail = '$mEmail', mPhoneNumber = '$mPhoneNumber', mAddress = '$mAddress', mPassword = '$mPassword' 
        WHERE managerID = '$managerID'
    ";

    if (mysqli_query($conn, $updateManagerSql)) {
        // Update type-specific fields
        if ($managerType === 'Head') {
            $departmentName = mysqli_real_escape_string($conn, $_POST['departmentName']);
            $teamSize = intval($_POST['teamSize']);
            $authorityLevel = mysqli_real_escape_string($conn, $_POST['authorityLevel']);
            $yearsOfExperience = intval($_POST['yearsOfExperience']);

            $updateTypeSql = "
                UPDATE headmanager 
                SET departmentName = '$departmentName', teamSize = $teamSize, authorityLevel = '$authorityLevel', yearsOfExperience = $yearsOfExperience
                WHERE HmanagerID = '$managerID'
            ";
        } elseif ($managerType === 'Financial') {
            $managedBudget = floatval($_POST['managedBudget']);
            $taxID = intval($_POST['taxID']);
            $pendingPayments = intval($_POST['pendingPayments']);

            $updateTypeSql = "
                UPDATE financialmanager 
                SET managedBudget = $managedBudget, taxID = $taxID, pendingPayments = $pendingPayments
                WHERE FmanagerID = '$managerID'
            ";
        } elseif ($managerType === 'Event') {
            $venueIncharge = mysqli_real_escape_string($conn, $_POST['venueIncharge']);
            $eventTypesHandled = mysqli_real_escape_string($conn, $_POST['eventTypesHandled']);

            $updateTypeSql = "
                UPDATE eventmanager 
                SET venueIncharge = '$venueIncharge', eventTypesHandled = '$eventTypesHandled'
                WHERE EmanagerID = '$managerID'
            ";
        }

        if (mysqli_query($conn, $updateTypeSql)) {
            echo "<script>alert('Manager updated successfully!'); window.location.href = 'manageManager.php';</script>";
        } else {
            echo "Error updating type-specific fields: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating manager: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Manager</title>
    <link rel="stylesheet" href="manageFoodsup.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>

    <main class="content">
        <header class="header">
            <h1>Update Manager</h1>
        </header>

        <form method="POST">
            <!-- Shared Fields -->
            <label for="mName">Name:</label>
            <input type="text" id="mName" name="mName" value="<?php echo htmlspecialchars($managerData['mName']); ?>" required>

            <label for="mEmail">Email:</label>
            <input type="email" id="mEmail" name="mEmail" value="<?php echo htmlspecialchars($managerData['mEmail']); ?>" required>

            <label for="mPhoneNumber">Phone Number:</label>
            <input type="text" id="mPhoneNumber" name="mPhoneNumber" value="<?php echo htmlspecialchars($managerData['mPhoneNumber']); ?>" required>

            <label for="mAddress">Address:</label>
            <textarea id="mAddress" name="mAddress" required><?php echo htmlspecialchars($managerData['mAddress']); ?></textarea>

            <label for="mPassword">Password:</label>
            <input type="password" id="mPassword" name="mPassword" value="<?php echo htmlspecialchars($managerData['mPassword']); ?>" required>

            <!-- Type-Specific Fields -->
            <?php if ($managerType === 'Head'): ?>
                <h2>Head Manager Details</h2>
                <label for="departmentName">Department Name:</label>
                <input type="text" id="departmentName" name="departmentName" value="<?php echo htmlspecialchars($typeSpecificData['departmentName']); ?>" required>

                <label for="teamSize">Team Size:</label>
                <input type="number" id="teamSize" name="teamSize" value="<?php echo htmlspecialchars($typeSpecificData['teamSize']); ?>" required>

                <label for="authorityLevel">Authority Level:</label>
                <input type="text" id="authorityLevel" name="authorityLevel" value="<?php echo htmlspecialchars($typeSpecificData['authorityLevel']); ?>" required>

                <label for="yearsOfExperience">Years of Experience:</label>
                <input type="number" id="yearsOfExperience" name="yearsOfExperience" value="<?php echo htmlspecialchars($typeSpecificData['yearsOfExperience']); ?>" required>

            <?php elseif ($managerType === 'Financial'): ?>
                <h2>Financial Manager Details</h2>
                <label for="managedBudget">Managed Budget:</label>
                <input type="number" step="0.01" id="managedBudget" name="managedBudget" value="<?php echo htmlspecialchars($typeSpecificData['managedBudget']); ?>" required>

                <label for="taxID">Tax ID:</label>
                <input type="number" id="taxID" name="taxID" value="<?php echo htmlspecialchars($typeSpecificData['taxID']); ?>" required>

                <label for="pendingPayments">Pending Payments:</label>
                <input type="number" id="pendingPayments" name="pendingPayments" value="<?php echo htmlspecialchars($typeSpecificData['pendingPayments']); ?>" required>

            <?php elseif ($managerType === 'Event'): ?>
                <h2>Event Manager Details</h2>
                <label for="venueIncharge">Venue Incharge:</label>
                <input type="text" id="venueIncharge" name="venueIncharge" value="<?php echo htmlspecialchars($typeSpecificData['venueIncharge']); ?>" required>

                <label for="eventTypesHandled">Event Types Handled:</label>
                <input type="text" id="eventTypesHandled" name="eventTypesHandled" value="<?php echo htmlspecialchars($typeSpecificData['eventTypesHandled']); ?>" required>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn update-btn">Update</button>
        </form>
    </main>
</div>
</body>
</html>
