<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize input
    $clientName = mysqli_real_escape_string($conn, $_POST['clientname']);
    $companyName = mysqli_real_escape_string($conn, $_POST['companyName']);
    $communicationMethod = mysqli_real_escape_string($conn, $_POST['communicationMethod']);
    $cPhoneNumber = mysqli_real_escape_string($conn, $_POST['cPhoneNumber']);
    $clientPass = mysqli_real_escape_string($conn, $_POST['clientPass']);
    $cDesignation = mysqli_real_escape_string($conn, $_POST['cDesignation']);
    $cEmail = mysqli_real_escape_string($conn, $_POST['cEmail']);
    $HmanagerID = mysqli_real_escape_string($conn, $_POST['HmanagerID']);

    // Insert into `client` table
    $sql = "INSERT INTO client (clientname, companyName, communicationMethod, cPhoneNumber, clientPass, cDesignation, cEmail, HmanagerID) 
            VALUES ('$clientName', '$companyName', '$communicationMethod', '$cPhoneNumber', '$clientPass', '$cDesignation', '$cEmail', '$HmanagerID')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Client added successfully!'); window.location.href = 'manageClient.php';</script>";
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch `HmanagerID` for dropdown
$sql_managers = "SELECT HmanagerID FROM headmanager";
$result_managers = mysqli_query($conn, $sql_managers);

if (!$result_managers) {
    die("Error fetching manager IDs: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Client</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        .main-content {
           width: 500px;
           background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <main class="main-content">
            <header class="header">
                <h1>Add Client</h1>
            </header>
            <div class="content-box">
                <form class="form" action="addCus.php" method="post">
                    <label for="clientname">Client Name:</label>
                    <input type="text" id="clientname" name="clientname" required>

                    <label for="companyName">Company Name:</label>
                    <input type="text" id="companyName" name="companyName" required>

                    <label for="communicationMethod">Communication Method:</label>
                    <select id="communicationMethod" name="communicationMethod" required>
                        <option value="Phone">Phone</option>
                        <option value="Email">Email</option>
                        <option value="Chat">Chat</option>
                    </select>

                    <label for="cPhoneNumber">Phone Number:</label>
                    <input type="text" id="cPhoneNumber" name="cPhoneNumber" required>

                    <label for="clientPass">Password:</label>
                    <input type="password" id="clientPass" name="clientPass" required>

                    <label for="cDesignation">Designation:</label>
                    <input type="text" id="cDesignation" name="cDesignation" required>

                    <label for="cEmail">Email:</label>
                    <input type="email" id="cEmail" name="cEmail" required>

                    <label for="HmanagerID">Manager ID:</label>
                    <select id="HmanagerID" name="HmanagerID" required>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_managers)) {
                            echo "<option value='" . htmlspecialchars($row['HmanagerID']) . "'>" . htmlspecialchars($row['HmanagerID']) . "</option>";
                        }
                        ?>
                    </select>

                    <button class="sub-btn" type="submit" name="submit">Add Client</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
