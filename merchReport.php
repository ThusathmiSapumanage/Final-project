<?php
include 'config.php'; // Include database configuration

// SQL Query
$sql = "
    SELECT 
        i.inventoryID AS 'Inventory ID',
        i.invetoryDescription AS 'Inventory Description',
        SUM(m.quantityInStock) AS 'Total Remaining Inventory',
        m.productName AS 'Merchandise Name',
        COUNT(bm.merchandiseID) AS 'Total Merchandise Bought'
    FROM inventory i
    LEFT JOIN merchandise m ON i.inventoryID = m.inventoryID
    LEFT JOIN boughtmerchandise bm ON m.merchandiseID = bm.merchandiseID
    GROUP BY i.inventoryID, i.invetoryDescription, m.productName
    ORDER BY `Total Merchandise Bought` DESC, `Total Remaining Inventory` ASC;
";

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
    <title>Inventory and Merchandise Report</title>
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
    </style>
</head>
<body>
    <h1>Inventory and Merchandise Report</h1>

    <?php if (count($data) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Inventory ID</th>
                    <th>Inventory Description</th>
                    <th>Total Remaining Inventory</th>
                    <th>Merchandise Name</th>
                    <th>Total Merchandise Bought</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Inventory ID']) ?></td>
                        <td><?= htmlspecialchars($row['Inventory Description']) ?></td>
                        <td><?= htmlspecialchars($row['Total Remaining Inventory']) ?></td>
                        <td><?= htmlspecialchars($row['Merchandise Name']) ?></td>
                        <td><?= htmlspecialchars($row['Total Merchandise Bought']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available to display.</p>
    <?php endif; ?>

    <div class="print-button">
        <button onclick="window.print()">Print Report</button>
        <button onclick="window.location.href='manageReports.php'">Back</button>
    </div>
</body>
</html>
