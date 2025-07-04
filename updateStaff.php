<?php

include "config.php";


$sID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $sID = intval($_POST['staffID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $availability = mysqli_real_escape_string($conn, $_POST['staffAvailability']);
    $userid = mysqli_real_escape_string($conn, $_POST['userid']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);


    // Update query
    $sql = "UPDATE staff 
            SET staffAvailability = '$availability',
                staffName = '$name', 
                userID = '$userid', 
                managerID = '$managerid'
                where staffID = $sID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageStaff.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}


$name = $userid = $managerid = $availability = "";

if ($sID > 0) {
    
    $sql2 = "SELECT * FROM staff WHERE staffID = $sID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $availability = $row['staffAvailability'];
        $name = $row['staffName'];
        $userid = $row['userID'];
        $managerid = $row['managerID'];
    }
}

// Fetch manager IDs for the dropdown
$sql3 = "SELECT managerID FROM manager";
$result2 = mysqli_query($conn, $sql3);

$sql4 = "SELECT userID FROM userlogin";
$result3 = mysqli_query($conn, $sql4);
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Update Staff </title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Staff Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Staff</h2>
                        <form class="form" action="updateStaff.php" method="post">

                        <label for="staffID">Staff ID:</label>
                        <input type="text" id="staffID" name="staffID" value="<?php echo $sID; ?>" readonly>

                        <label for="name">Staff Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                        <label for="staffAvailability">Staff Availability:</label>
                        <input type="text" id="staffAvailability" name="staffAvailability" value="<?php echo htmlspecialchars($availability); ?>" required>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    $selected = ($row['managerID'] == $managerid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['managerID']) . "' $selected>" . htmlspecialchars($row['managerID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select><br>

                        <label for = "userid">User ID:</label>
                        <select id="userid" name="userid" required>
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = $result3->fetch_assoc()) {
                                    $selected = ($row['userID'] == $userid) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['userID']) . "' $selected>" . htmlspecialchars($row['userID']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No User IDs Available</option>";
                            }
                            ?>
                        </select><br>
                        <button class="sub-btn" type="submit" name="submit">Update Staff</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>