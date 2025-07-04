<?php
include 'config.php';

// Get customer ID from the query parameter
$clientID = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$clientID) {
    echo "<script>alert('Invalid Customer ID.'); window.location.href = 'manageClient.php';</script>";
    exit;
}

// Fetch existing customer data
$sql = "SELECT * FROM client WHERE clientID = $clientID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Customer not found.'); window.location.href = 'manageClient.php';</script>";
    exit;
}

$customer = mysqli_fetch_assoc($result);

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $clientname = mysqli_real_escape_string($conn, $_POST['clientname']);
    $companyName = mysqli_real_escape_string($conn, $_POST['companyName']);
    $communicationMethod = mysqli_real_escape_string($conn, $_POST['communicationMethod']);
    $cPhoneNumber = mysqli_real_escape_string($conn, $_POST['cPhoneNumber']);
    $clientPass = mysqli_real_escape_string($conn, $_POST['clientPass']);
    $cDesignation = mysqli_real_escape_string($conn, $_POST['cDesignation']);
    $cEmail = mysqli_real_escape_string($conn, $_POST['cEmail']);
    $HmanagerID = mysqli_real_escape_string($conn, $_POST['HmanagerID']);

    // Update customer in the database
    $sql = "UPDATE client 
            SET clientname = '$clientname', companyName = '$companyName', communicationMethod = '$communicationMethod',
                cPhoneNumber = '$cPhoneNumber', clientPass = '$clientPass', cDesignation = '$cDesignation', 
                cEmail = '$cEmail', HmanagerID = '$HmanagerID'
            WHERE clientID = $clientID";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Customer updated successfully!'); window.location.href = 'manageClient.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Customer</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">
    <?php include 'header.php'; ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <h1 style = 'color: black;'>Update Customer</h1>
        </header>
        <div class="content-inner">
            <div class="content-box">
                <h2>Edit Customer Details</h2><br>
                <form class="form" action="" method="post">
                    <label for="clientname">Customer Name:</label>
                    <input type="text" id="clientname" name="clientname" value="<?php echo htmlspecialchars($customer['clientname']); ?>" required>

                    <label for="companyName">Company Name:</label>
                    <input type="text" id="companyName" name="companyName" value="<?php echo htmlspecialchars($customer['companyName']); ?>">

                    <label for="communicationMethod">Communication Method:</label>
                    <select id="communicationMethod" name="communicationMethod" required>
                        <option value="Email" <?php if ($customer['communicationMethod'] == 'Email') echo 'selected'; ?>>Email</option>
                        <option value="Phone" <?php if ($customer['communicationMethod'] == 'Phone') echo 'selected'; ?>>Phone</option>
                        <option value="SMS" <?php if ($customer['communicationMethod'] == 'SMS') echo 'selected'; ?>>SMS</option>
                    </select>

                    <label for="cPhoneNumber">Contact Number:</label>
                    <input type="text" id="cPhoneNumber" name="cPhoneNumber" value="<?php echo htmlspecialchars($customer['cPhoneNumber']); ?>" required>

                    <label for="clientPass">Password:</label>
                    <input type="text" id="clientPass" name="clientPass" value="<?php echo htmlspecialchars($customer['clientPass']); ?>" required>

                    <label for="cDesignation">Designation:</label>
                    <input type="text" id="cDesignation" name="cDesignation" value="<?php echo htmlspecialchars($customer['cDesignation']); ?>">

                    <label for="cEmail">Email:</label>
                    <input type="email" id="cEmail" name="cEmail" value="<?php echo htmlspecialchars($customer['cEmail']); ?>" required>

                    <label for="HmanagerID">Manager ID:</label>
                    <select id="HmanagerID" name="HmanagerID" required>
                        <option value="">Select Manager</option>
                        <?php
                        $sql = "SELECT HmanagerID FROM headmanager";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['HmanagerID'] == $customer['HmanagerID']) ? "selected" : "";
                                echo "<option value='{$row['HmanagerID']}' $selected>{$row['HmanagerID']}</option>";
                            }
                        }
                        ?>
                    </select>

                    <button class="sub-btn" type="submit" name="update">Update Customer</button>
                </form>
            </div>
        </div>
    </main>
    </div>
</body>
</html>
