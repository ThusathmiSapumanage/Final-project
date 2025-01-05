<?php
include 'config.php'; // Include database configuration

// SQL Query
$sql = "
    SELECT 
        hs.staffName,
        hs.staffType,
        hs.hourlyRate,
        t.taskStatus,
        COUNT(t.taskID) AS totalTasks,
        SUM(CASE WHEN ot.taskID IS NOT NULL THEN 1 ELSE 0 END) AS oneTimeTasks,
        SUM(CASE WHEN rt.taskID IS NOT NULL THEN 1 ELSE 0 END) AS recurringTasks
    FROM hiringstaff hs
    LEFT JOIN task t ON hs.staffID = t.staffID
    LEFT JOIN onetimetask ot ON t.taskID = ot.taskID
    LEFT JOIN recurringtask rt ON t.taskID = rt.taskID
    GROUP BY hs.staffID, hs.staffName, hs.staffType, hs.hourlyRate, t.taskStatus
    ORDER BY totalTasks DESC;";

// Execute the Query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Fetch the Data
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Task Report with Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .print-button {
            margin-top: 20px;
            text-align: center;
        }
        .print-button button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>Staff Task Report with Status</h1>

    <?php if (count($data) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Staff Type</th>
                    <th>Hourly Rate</th>
                    <th>Task Status</th>
                    <th>Total Tasks</th>
                    <th>One-Time Tasks</th>
                    <th>Recurring Tasks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['staffName']) ?></td>
                        <td><?= htmlspecialchars($row['staffType']) ?></td>
                        <td><?= htmlspecialchars($row['hourlyRate']) ?></td>
                        <td><?= htmlspecialchars($row['taskStatus']) ?></td>
                        <td><?= htmlspecialchars($row['totalTasks']) ?></td>
                        <td><?= htmlspecialchars($row['oneTimeTasks']) ?></td>
                        <td><?= htmlspecialchars($row['recurringTasks']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available to display.</p>
    <?php endif; ?>

    <div class="print-button">
        <button onclick="window.print()">Print Report</button>
        <button onclick="window.location.href = 'manageReports.php'">Back</button>
    </div>
</body>
</html>
