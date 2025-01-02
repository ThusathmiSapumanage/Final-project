<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $staffID = mysqli_real_escape_string($conn, $_POST['staffID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $staffType = mysqli_real_escape_string($conn, $_POST['staffType']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $hourlyRate = mysqli_real_escape_string($conn, $_POST['hourlyRate']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password

    // Insert into `hiringstaff` table
    $sql = "INSERT INTO hiringstaff (staffID, staffName, staffType, staffAvailability, hourlyRate, HmanagerID, staffPassword) 
            VALUES ('$staffID', '$name', '$staffType', '$availability', '$hourlyRate', '$managerID', '$password')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the respective form for additional details
        if ($staffType === "Photographer") {
            header("Location: addPhotographer.php?staffID=$staffID");
        } elseif ($staffType === "Graphic Designer") {
            header("Location: addGraphicDesigner.php?staffID=$staffID");
        }
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch manager IDs for dropdown
$sql = "SELECT HmanagerID FROM headmanager";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">
    <?php include 'header.php'; ?>

        <main class="content">
            <header class="header">
                <h1>Staff Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Staff</h2>
                    <form class="form" action="addStaff.php" method="post">
                        <label for="staffID">Staff ID:</label>
                        <input type="text" id="staffID" name="staffID" placeholder = "PSID or photogprahers and GDID for graphic designers" required>

                        <label for="name">Staff Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="staffType">Staff Type:</label>
                        <select id="staffType" name="staffType" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Photographer">Photographer</option>
                            <option value="Graphic Designer">Graphic Designer</option>
                        </select><br>

                        <label for="availability">Availability:</label>
                        <select id="availability" name="availability" required>
                            <option value="" disabled selected>Select Availability</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                        </select><br>

                        <label for="hourlyRate">Hourly Rate:</label>
                        <input type="number" id="hourlyRate" name="hourlyRate" step="0.01" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <label for="managerID">Manager ID:</label>
                        <select id="managerID" name="managerID" required>
                            <option value="" disabled selected>Select Manager</option>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row['HmanagerID']) . "'>" . htmlspecialchars($row['HmanagerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select><br>

                        <button class="sub-btn" type="submit" name="submit">Next</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
