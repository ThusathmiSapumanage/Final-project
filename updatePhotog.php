<?php

include "config.php";

// Fetch photographer details based on ID
$staffID = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if ($staffID) {
    // Fetch hiring staff details
    $sql_hiringstaff = "SELECT * FROM hiringstaff WHERE staffID = '$staffID'";
    $result_hiringstaff = mysqli_query($conn, $sql_hiringstaff);

    // Fetch photographer-specific details
    $sql_photographer = "SELECT * FROM photographer WHERE PstaffID = '$staffID'";
    $result_photographer = mysqli_query($conn, $sql_photographer);

    if (mysqli_num_rows($result_hiringstaff) > 0 && mysqli_num_rows($result_photographer) > 0) {
        $hiringstaff = mysqli_fetch_assoc($result_hiringstaff);
        $photographer = mysqli_fetch_assoc($result_photographer);
    } else {
        echo "<script>alert('Invalid Photographer ID. Redirecting back...');</script>";
        echo "<script>window.location.href = 'manageStaff.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Photographer ID not provided. Redirecting back...');</script>";
    echo "<script>window.location.href = 'manageStaff.php';</script>";
    exit;
}

// Update photographer details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $hourlyRate = mysqli_real_escape_string($conn, $_POST['hourlyRate']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $eventCoverageCount = mysqli_real_escape_string($conn, $_POST['eventCoverageCount']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    // Update hiring staff table
    $sql_update_hiringstaff = "
        UPDATE hiringstaff 
        SET staffName = '$name',
            staffAvailability = '$availability',
            hourlyRate = '$hourlyRate',
            HmanagerID = '$managerID',
            staffPassword = '$password'
        WHERE staffID = '$staffID'
    ";

    // Update photographer-specific table
    $sql_update_photographer = "
        UPDATE photographer 
        SET eventCoverageCount = '$eventCoverageCount',
            specialization = '$specialization'
        WHERE PstaffID = '$staffID'
    ";

    // Execute the updates
    if (mysqli_query($conn, $sql_update_hiringstaff) && mysqli_query($conn, $sql_update_photographer)) {
        echo "<script>alert('Photographer updated successfully!');</script>";
        echo "<script>window.location.href = 'manageStaff.php';</script>";
        exit;
    } else {
        echo "Error updating photographer: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Photographer</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">
        
    <?php include 'header.php'; ?>


        <main class="content">
            <header class="header">
                <h1>Update Photographer</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" action="updatePhotog.php?id=<?php echo htmlspecialchars($staffID); ?>" method="post">
                        <label for="staffID">Staff ID:</label>
                        <input type="text" id="staffID" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" readonly>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($hiringstaff['staffName']); ?>" required>

                        <label for="availability">Availability:</label>
                        <select id="availability" name="availability" required>
                            <option value="Available" <?php if ($hiringstaff['staffAvailability'] == 'Available') echo 'selected'; ?>>Available</option>
                            <option value="Not Available" <?php if ($hiringstaff['staffAvailability'] == 'Not Available') echo 'selected'; ?>>Not Available</option>
                        </select>
                        <br>

                        <label for="hourlyRate">Hourly Rate:</label>
                        <input type="number" id="hourlyRate" name="hourlyRate" step="0.01" value="<?php echo htmlspecialchars($hiringstaff['hourlyRate']); ?>" required>

                        <label for="managerID">Manager ID:</label>
                        <select id="managerID" name="managerID" required>
                            <?php
                            $sql_managers = "SELECT HmanagerID FROM headmanager";
                            $result_managers = mysqli_query($conn, $sql_managers);

                            if (mysqli_num_rows($result_managers) > 0) {
                                while ($manager = mysqli_fetch_assoc($result_managers)) {
                                    echo "<option value='" . $manager['HmanagerID'] . "' " . ($data['HmanagerID'] == $manager['HmanagerID'] ? 'selected' : '') . ">" . $manager['HmanagerID'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($hiringstaff['staffPassword']); ?>" required>

                        <label for="eventCoverageCount">Event Coverage Count:</label>
                        <input type="number" id="eventCoverageCount" name="eventCoverageCount" value="<?php echo htmlspecialchars($photographer['eventCoverageCount']); ?>" required>

                        <label for="specialization">Specialization:</label>
                        <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($photographer['specialization']); ?>" required>

                        <button class="sub-btn" type="submit" name="submit">Update Photographer</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
