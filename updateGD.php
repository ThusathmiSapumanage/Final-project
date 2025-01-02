<?php

include "config.php";

// Get the `staffID` from the URL
$staffID = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if (!$staffID) {
    echo "<script>alert('Invalid Staff ID! Redirecting back...');</script>";
    echo "<script>window.location.href = 'manageStaff.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and collect form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $hourlyRate = mysqli_real_escape_string($conn, $_POST['hourlyRate']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $managerID = mysqli_real_escape_string($conn, $_POST['managerID']);
    $designTools = mysqli_real_escape_string($conn, $_POST['designTools']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    // Update `hiringstaff` table
    $sql_hiringstaff = "
        UPDATE hiringstaff
        SET 
            staffName = '$name',
            staffAvailability = '$availability',
            hourlyRate = '$hourlyRate',
            staffPassword = '$password',
            HmanagerID = '$managerID'
        WHERE staffID = '$staffID'
    ";

    // Update `graphicdesigner` table
    $sql_graphicdesigner = "
        UPDATE graphicdesigner
        SET 
            designTools = '$designTools',
            experience = '$experience'
        WHERE GstaffID = '$staffID'
    ";

    if (mysqli_query($conn, $sql_hiringstaff) && mysqli_query($conn, $sql_graphicdesigner)) {
        echo "<script>alert('Graphic Designer updated successfully!');</script>";
        echo "<script>window.location.href = 'manageStaff.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Fetch current data for the staffID
$sql = "
    SELECT h.*, g.designTools, g.experience 
    FROM hiringstaff h 
    JOIN graphicdesigner g ON h.staffID = g.GstaffID 
    WHERE h.staffID = '$staffID'
";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Record not found! Redirecting back...');</script>";
    echo "<script>window.location.href = 'manageStaff.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Graphic Designer</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">

    <?php include 'header.php'; ?>

        
        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Update Graphic Designer</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Edit Details</h2>
                    <form class="form" action="updateGD.php?id=<?php echo htmlspecialchars($staffID); ?>" method="post">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['staffName']); ?>" required>

                        <label for="availability">Availability:</label>
                       <select id="availability" name="availability" required>
                            <option value="Full-Time" <?php if ($data['staffAvailability'] == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                            <option value="Part-Time" <?php if ($data['staffAvailability'] == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                        </select>
                        <br>

                        <label for="hourlyRate">Hourly Rate:</label>
                        <input type="number" id="hourlyRate" name="hourlyRate" value="<?php echo htmlspecialchars($data['hourlyRate']); ?>" step="0.01" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($data['staffPassword']); ?>" required>

                        <label for="managerID">Manager ID:</label>
                        <select id="managerID" name="managerID" required>
                            <?php
                            $sql_manager = "SELECT HmanagerID FROM headmanager";
                            $result_manager = mysqli_query($conn, $sql_manager);

                            if (mysqli_num_rows($result_manager) > 0) {
                                while ($manager = mysqli_fetch_assoc($result_manager)) {
                                    echo "<option value='" . $manager['HmanagerID'] . "' " . ($data['HmanagerID'] == $manager['HmanagerID'] ? 'selected' : '') . ">" . $manager['HmanagerID'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br>

                        <label for="designTools">Design Tools:</label>
                        <input type="text" id="designTools" name="designTools" value="<?php echo htmlspecialchars($data['designTools']); ?>" required>

                        <label for="experience">Experience (in years):</label>
                        <input type="number" id="experience" name="experience" value="<?php echo htmlspecialchars($data['experience']); ?>" step="1" required>

                        <button class="sub-btn" type="submit" name="submit">Update</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
