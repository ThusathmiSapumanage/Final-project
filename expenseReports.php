<?php
include 'config.php'; // Include your database connection

// Fetch all data from the expenses table
$sql = "SELECT * FROM expenses ORDER BY expenseDate ASC";
$result = mysqli_query($conn, $sql);

// Initialize an array to store the data
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expense Report Data</title>
    <link rel="stylesheet" href="reportStyles.css">
</head>
<body>
    <div class="report-container">
        <header class="report-header">
            <h1>Expense Report</h1>
            <p>Date Generated: <?php echo date('Y-m-d'); ?></p>
        </header>
        
        <table class="report-table">
            <thead>
                <tr>
                    <th>Expense ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Payable</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Manager ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['expenseID']; ?></td>
                        <td><?php echo $row['expenseDate']; ?></td>
                        <td><?php echo $row['expenseType']; ?></td>
                        <td><?php echo number_format($row['expenseAmount'], 2); ?></td>
                        <td><?php echo number_format($row['expensePayableM'], 2); ?></td>
                        <td><?php echo $row['expenseStatus']; ?></td>
                        <td><?php echo $row['expenseDes']; ?></td>
                        <td><?php echo $row['managerID']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="print-button">
            <button onclick="window.print()">Print Report</button>
        </div>
        <div class = "back-button">
            <a href="financeM.html"><button class = "back">Back</button></a>
        </div>
    </div>
</body>
</html>
