<?php
include 'config.php'; // Include database configuration

// SQL Query for Clients with Most Events
$sqlClients = "
    SELECT 
        c.clientName AS 'Client Name',
        c.companyName AS 'Company Name',
        COUNT(e.eventID) AS 'Total Events'
    FROM client c
    LEFT JOIN events e ON c.clientID = e.ClientID
    WHERE e.eventStatus IS NOT NULL
    GROUP BY c.clientID, c.clientName, c.companyName
    ORDER BY `Total Events` DESC;
";

$sqlMonths = "
    SELECT 
        MONTHNAME(e.eventStart) AS 'Month',
        COUNT(e.eventID) AS 'Total Events'
    FROM events e
    WHERE e.eventStatus IS NOT NULL
    GROUP BY MONTH(e.eventStart)
    ORDER BY `Total Events` DESC;
";

// Execute Queries
$resultClients = mysqli_query($conn, $sqlClients);
$resultMonths = mysqli_query($conn, $sqlMonths);

if (!$resultClients || !$resultMonths) {
    die("Error executing query: " . mysqli_error($conn));
}

// Fetch Data
$dataClients = [];
while ($row = mysqli_fetch_assoc($resultClients)) {
    $dataClients[] = $row;
}

$dataMonths = [];
while ($row = mysqli_fetch_assoc($resultMonths)) {
    $dataMonths[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1, h2 {
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
    </style>
</head>
<body>
    <h1>Event Report</h1>

    <h2>Clients with the Most Events</h2>
    <?php if (count($dataClients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Company Name</th>
                    <th>Total Events</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataClients as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Client Name']) ?></td>
                        <td><?= htmlspecialchars($row['Company Name']) ?></td>
                        <td><?= htmlspecialchars($row['Total Events']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available for clients.</p>
    <?php endif; ?>

    <h2>Events by Month</h2>
    <?php if (count($dataMonths) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Events</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataMonths as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Month']) ?></td>
                        <td><?= htmlspecialchars($row['Total Events']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available for events by month.</p>
    <?php endif; ?>

    <div class="print-button">
        <button onclick="window.print()">Print Report</button>
        <button onclick="window.location.href='manageReports.php'">Back</button>
    </div>
</body>
</html>
