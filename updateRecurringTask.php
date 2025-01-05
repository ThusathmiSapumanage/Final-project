<?php
include "config.php";

// Get the task ID from the query string
$taskID = isset($_GET['taskID']) ? mysqli_real_escape_string($conn, $_GET['taskID']) : '';

if ($taskID) {
    // Fetch data for the specific task
    $sql = "
        SELECT t.*, r.isPaused, r.recurrenceInterval, r.recurringTassigned 
        FROM task t 
        JOIN recurringtask r ON t.taskID = r.taskID 
        WHERE t.taskID = '$taskID'
    ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Task not found. Redirecting to Task Management...');</script>";
        echo "<script>window.location.href = 'manageTasks.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Task ID is missing. Redirecting to Task Management...');</script>";
    echo "<script>window.location.href = 'manageTasks.php';</script>";
    exit;
}

// Handle form submission to update the task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $isPaused = mysqli_real_escape_string($conn, $_POST['isPaused']);
    $recurrenceInterval = mysqli_real_escape_string($conn, $_POST['recurrenceInterval']);
    $recurringTassigned = mysqli_real_escape_string($conn, $_POST['recurringTassigned']);

    // Update the `recurringtask` table
    $sqlUpdateRecurring = "
        UPDATE recurringtask 
        SET isPaused = '$isPaused', 
            recurrenceInterval = '$recurrenceInterval', 
            recurringTassigned = '$recurringTassigned' 
        WHERE taskID = '$taskID'
    ";

    if (mysqli_query($conn, $sqlUpdateRecurring)) {
        echo "<script>alert('Recurring Task updated successfully! Redirecting to Task Management...');</script>";
        echo "<script>window.location.href = 'manageTasks.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Recurring Task</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <main class="main-content">
            <header class="header">
                <h1 style = 'color: black;'>Update Recurring Task</h1>
            </header>
            <div class="content-box">
                <form class="form" action="updateRecurringTask.php?taskID=<?php echo htmlspecialchars($taskID); ?>" method="post">
                    <label for="isPaused">Is Paused:</label>
                    <select id="isPaused" name="isPaused" required>
                        <option value="No" <?php if ($data['isPaused'] == 'No') echo 'selected'; ?>>No</option>
                        <option value="Yes" <?php if ($data['isPaused'] == 'Yes') echo 'selected'; ?>>Yes</option>
                    </select>

                    <label for="recurrenceInterval">Recurrence Interval (days):</label>
                    <input type="number" id="recurrenceInterval" name="recurrenceInterval" value="<?php echo htmlspecialchars($data['recurrenceInterval']); ?>" required>

                    <label for="recurringTassigned">Recurring Task Assigned:</label>
                    <select id="recurringTassigned" name="recurringTassigned" required>
                        <option value="Graphic Designer" <?php if ($data['recurringTassigned'] == 'Graphic Designer') echo 'selected'; ?>>Graphic Designer</option>
                        <option value="Photographer" <?php if ($data['recurringTassigned'] == 'Photographer') echo 'selected'; ?>>Photographer</option>
                    </select>

                    <button class="update-btn" type="submit" name="submit">Update Task</button>
                    <button class="back-btn" onclick="window.location.href = 'manageTasks.php';" type="button">Back</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
