<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $isPaused = mysqli_real_escape_string($conn, $_POST['isPaused']);
    $recurrenceInterval = mysqli_real_escape_string($conn, $_POST['recurrenceInterval']);
    $recurringTassigned = mysqli_real_escape_string($conn, $_POST['recurringTassigned']);

    // Check if taskID exists in `task` table
    $checkTaskID = "SELECT taskID FROM task WHERE taskID = '$taskID'";
    $result = mysqli_query($conn, $checkTaskID);

    if (mysqli_num_rows($result) > 0) {
        // Insert into `recurringtask` table
        $sql = "INSERT INTO recurringtask (taskID, isPaused, recurrenceInterval, recurringTassigned) 
                VALUES ('$taskID', '$isPaused', '$recurrenceInterval', '$recurringTassigned')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Recurring task added successfully! Redirecting to Task Management.');</script>";
            echo "<script>window.location.href = 'manageTasks.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Task ID does not exist in the main task table.');</script>";
    }
}

$taskID = isset($_GET['taskID']) ? $_GET['taskID'] : '';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Recurring Task</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar remains unchanged -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Recurring Task Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Recurring Task</h2>
                    <form class="form" action="addRecurringTask.php" method="post">
                        <input type="hidden" name="taskID" value="<?php echo htmlspecialchars($taskID); ?>">

                        <label for="isPaused">Is Paused:</label>
                        <select id="isPaused" name="isPaused" required>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                        <br>

                        <label for="recurrenceInterval">Recurrence Interval (days):</label>
                        <input type="number" id="recurrenceInterval" name="recurrenceInterval" required>

                        <label for="recurringTassigned">Recurring Task Assigned:</label>
                        <select id="recurringTassigned" name="recurringTassigned" required>
                            <option value="Graphic Designer">Graphic Designer</option>
                            <option value="Photographer">Photographer</option>
                        </select>
                        <br>

                        <button class="sub-btn" type="submit" name="submit">Add Task</button>
                        <button class="back-btn" onclick="window.location.href = 'manageTasks.php';" type="button">Back</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
