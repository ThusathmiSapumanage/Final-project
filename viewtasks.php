<?php

include "config.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Tasks</title>
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
                <h1>Tasks</h1>
            </header>

            <!-- Recurring Tasks Section -->
            <section class="table-section">
                <h2>Recurring Tasks</h2>
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
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No records found</td></tr>";
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
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No records found</td></tr>";
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
