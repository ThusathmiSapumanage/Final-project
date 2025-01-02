<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $taskdes = mysqli_real_escape_string($conn, $_POST['taskdes']);
    $due = mysqli_real_escape_string($conn, $_POST['due']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $managerid = mysqli_real_escape_string($conn, $_POST['managerid']);
    $staffid = mysqli_real_escape_string($conn, $_POST['staffid']);
    $taskType = mysqli_real_escape_string($conn, $_POST['taskType']);

    // Insert into main `tasks` table
    $sql = "INSERT INTO task (taskID, taskDescription, taskDueDate, taskStatus, HmanagerID, staffID, taskType) VALUES ('$taskID', '$taskdes', '$due', '$status', '$managerid', '$staffid', '$taskType')";
    
    // Main task logic - task ID is user-defined
    if (mysqli_query($conn, $sql)) {
        // Redirect to the appropriate form
        if ($taskType === "Recurring") {
            header("Location: addRecurringTask.php?taskID=$taskID");
        } elseif ($taskType === "One-Time") {
            header("Location: addOneTimeTask.php?taskID=$taskID");
        }
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

// Fetch manager IDs for dropdown
$sql = "SELECT HmanagerID FROM headmanager";
$result = mysqli_query($conn, $sql);

// Fetch staff IDs for dropdown
$sql2 = "SELECT staffID FROM hiringstaff";
$result2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">

    <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Task Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Task</h2>
                    <form class="form" action="addTask.php" method="post">

                        <label for = "taskID">Task ID:</label>
                        <input type="text" id="taskID" name="taskID" placeholder = "RTID for recurring tasks and OTID for onetime tasks" required>

                        <label for="taskdes">Task Description:</label>
                        <input type="text" id="taskdes" name="taskdes" required>

                        <label for="due">Task Due Date:</label>
                        <input type="date" id="due" name="due" required>

                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="" disabled selected>Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select><br>

                        <label for="taskType">Task Type:</label>
                        <select id="taskType" name="taskType" required>
                            <option value="" disabled selected>Select Task Type</option>
                            <option value="Recurring">Recurring</option>
                            <option value="One-Time">One-Time</option>
                        </select><br>

                        <label for="managerid">Manager ID:</label>
                        <select id="managerid" name="managerid" required>
                            <option value="" disabled selected>Select Manager</option>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['HmanagerID'] . "'>" . $row['HmanagerID'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Managers Available</option>";
                            }
                            ?>
                        </select><br>

                        <label for="staff">Staff ID:</label>
                        <select id="staffid" name="staffid" required>
                            <option value="" disabled selected>Select Staff ID</option>
                            <?php
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    echo "<option value='" . $row['staffID'] . "'>" . $row['staffID'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No staff available</option>";
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
