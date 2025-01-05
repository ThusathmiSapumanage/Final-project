<?php
include "config.php";

// Get the task ID from the query string
$taskID = isset($_GET['taskID']) ? mysqli_real_escape_string($conn, $_GET['taskID']) : '';

if ($taskID) {
    // Fetch data for the specific task
    $sql = "
        SELECT t.*, o.completionDate, o.priorityLevel, o.OTassigned 
        FROM task t 
        JOIN onetimetask o ON t.taskID = o.taskID 
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
    $completionDate = mysqli_real_escape_string($conn, $_POST['completionDate']);
    $priorityLevel = mysqli_real_escape_string($conn, $_POST['priorityLevel']);
    $OTassigned = mysqli_real_escape_string($conn, $_POST['OTassigned']);

    // Update the `onetimetask` table
    $sqlUpdateOneTime = "
        UPDATE onetimetask 
        SET completionDate = '$completionDate', 
            priorityLevel = '$priorityLevel', 
            OTassigned = '$OTassigned' 
        WHERE taskID = '$taskID'
    ";

    if (mysqli_query($conn, $sqlUpdateOneTime)) {
        echo "<script>alert('One-Time Task updated successfully! Redirecting to Task Management...');</script>";
        echo "<script>window.location.href = 'manageTasks.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update One-Time Task</title>
    <link rel="stylesheet" type="text/css" href="commonupdate.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <main class="main-content">
            <header class="header">
                <h1 style = 'color: black;'>Update One-Time Task</h1>
            </header>
            <div class="content-box">
                <form class="form" action="updateOneTimeTask.php?taskID=<?php echo htmlspecialchars($taskID); ?>" method="post">
                    <label for="completionDate">Completion Date:</label>
                    <input type="date" id="completionDate" name="completionDate" value="<?php echo htmlspecialchars($data['completionDate']); ?>" required>

                    <label for="priorityLevel">Priority Level:</label>
                    <select id="priorityLevel" name="priorityLevel" required>
                        <option value="High" <?php if ($data['priorityLevel'] == 'High') echo 'selected'; ?>>High</option>
                        <option value="Medium" <?php if ($data['priorityLevel'] == 'Medium') echo 'selected'; ?>>Medium</option>
                        <option value="Low" <?php if ($data['priorityLevel'] == 'Low') echo 'selected'; ?>>Low</option>
                    </select>

                    <label for="OTassigned">One-Time Task Assigned:</label>
                    <select id="OTassigned" name="OTassigned" required>
                        <option value="Graphic Designer" <?php if ($data['OTassigned'] == 'Graphic Designer') echo 'selected'; ?>>Graphic Designer</option>
                        <option value="Photographer" <?php if ($data['OTassigned'] == 'Photographer') echo 'selected'; ?>>Photographer</option>
                    </select>

                    <button class="update-btn" type="submit" name="submit">Update Task</button>
                    <button class="back-btn" onclick="window.location.href = 'manageTasks.php';" type="button">Back</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
