<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $completionDate = mysqli_real_escape_string($conn, $_POST['completionDate']);
    $priorityLevel = mysqli_real_escape_string($conn, $_POST['priorityLevel']);
    $OTassigned = mysqli_real_escape_string($conn, $_POST['OTassigned']);

    // Check if taskID exists in `task` table
    $checkTaskID = "SELECT taskID FROM task WHERE taskID = '$taskID'";
    $result = mysqli_query($conn, $checkTaskID);

    if (mysqli_num_rows($result) > 0) {
        // Insert into `onetimetask` table
        $sql = "INSERT INTO onetimetask (taskID, completionDate, priorityLevel, OTassigned) 
                VALUES ('$taskID', '$completionDate', '$priorityLevel', '$OTassigned')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('One-Time task added successfully! Redirecting to Task Management.');</script>";
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
    <title>Add One-Time Task</title>
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar remains unchanged -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>One-Time Task Management</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add One-Time Task</h2>
                    <form class="form" action="addOneTimeTask.php" method="post">
                        <input type="hidden" name="taskID" value="<?php echo htmlspecialchars($taskID); ?>">

                        <label for="completionDate">Completion Date:</label>
                        <input type="text" id="completionDate" name="completionDate" value="Not completed" required readonly>

                        <label for="priorityLevel">Priority Level:</label>
                        <select id="priorityLevel" name="priorityLevel" required>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                        <br>

                        <label for="OTassigned">One-Time Task Assigned:</label>
                        <select id="OTassigned" name="OTassigned" required>
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
