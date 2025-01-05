<?php

include "config.php";

// Handle DELETE action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // Check if task exists in the main `task` table
    $checkTaskID = "SELECT * FROM task WHERE taskID = '$taskID'";
    $taskExists = mysqli_query($conn, $checkTaskID);

    if (mysqli_num_rows($taskExists) > 0) {
        // Delete from `recurringtask` if applicable
        $sqlDeleteRecurring = "DELETE FROM recurringtask WHERE taskID = '$taskID'";
        mysqli_query($conn, $sqlDeleteRecurring);

        // Delete from `onetimetask` if applicable
        $sqlDeleteOneTime = "DELETE FROM onetimetask WHERE taskID = '$taskID'";
        mysqli_query($conn, $sqlDeleteOneTime);

        // Delete from main `task` table
        $sqlDeleteTask = "DELETE FROM task WHERE taskID = '$taskID'";
        if (mysqli_query($conn, $sqlDeleteTask)) {
            echo "<script>alert('Task deleted successfully! Redirecting to the view page...');</script>";
            echo "<script>window.location.href = 'manageTasks.php';</script>";
        } else {
            echo "Error deleting task: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Task ID does not exist in the main task table.');</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Tasks</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        }

        .table-container {
        background-color: white;
        width: 100%;	
        height: 100%;
        }

        .custom-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 200px; /* Sidebar width */
        background: #151515; /* Sidebar background color */
        color: white;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .menu {
        list-style: none;
        padding: 0;
        margin: 0;
        }

        .custom-sidebar .menu a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: background 0.3s;
        }

        .custom-sidebar .menu a:hover,
        .custom-sidebar .menu a.active {
        background: #fdb827;
        color: black;
        }

        .main-content {
        margin-left: 220px; /* Sidebar width */
        padding: 20px;
        background-color: #ffffff; /* White background for content */
        width: 100%;
        }
        .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: #fdb827;
        color: black;
        text-decoration: none;
        border-radius: 5px;
        }
        .add-btn
        {
            background-color: #fdb827;
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .add-btn a
        {
            color: black;
            text-decoration: none;
        }
        .back-btn
        {
            background-color: #f44336;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Task Management</h1>
            </header>

            <!-- Recurring Tasks Section -->
            <section class="table-section">
                <h2>Recurring Tasks</h2>
                <button class="add-btn"><a href="addTask.php">Add Task</a></button>
                <button class="back-btn" onclick="window.location.href = 'staffM.php';">Back</button>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Manager ID</th>
                                <th>Staff ID</th>
                                <th>Paused</th>
                                <th>Recurrence Interval</th>
                                <th>Assigned Recurring</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT t.*, r.isPaused, r.recurrenceInterval, r.recurringTassigned 
                                    FROM task t 
                                    JOIN recurringtask r ON t.taskID = r.taskID";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['taskID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskDueDate']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskStatus']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['isPaused']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['recurrenceInterval']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['recurringTassigned']) . "</td>";
                                    echo "<td class='actions'>
                                            <a href='updateRecurringTask.php?taskID=" . htmlspecialchars($row['taskID']) . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['taskID']) . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- One-Time Tasks Section -->
            <section class="table-section">
                <h2>One-Time Tasks</h2>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Manager ID</th>
                                <th>Staff ID</th>
                                <th>Completion Date</th>
                                <th>Priority Level</th>
                                <th>Assigned One-Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT t.*, o.completionDate, o.priorityLevel, o.OTassigned 
                                    FROM task t 
                                    JOIN onetimetask o ON t.taskID = o.taskID";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['taskID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskDueDate']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['taskStatus']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['completionDate']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['priorityLevel']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['OTassigned']) . "</td>";
                                    echo "<td class='actions'>
                                            <a href='updateOneTimeTask.php?taskID=" . htmlspecialchars($row['taskID']) . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['taskID']) . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
