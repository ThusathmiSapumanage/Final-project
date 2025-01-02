<?php
include 'config.php'; // Include your database connection

// Fetch all data from the expenses table
$sql = "SELECT * FROM expenses ORDER BY expensePaymentDate ASC";
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
    <title>Expense Report</title>
    <link rel="stylesheet" href="reportStyles.css">
</head>
<body>
    <div class="report-container">
        <!-- Report Header -->
        <header class="report-header">
            <h1>Expense Report</h1>
            <p>Date Generated: <?php echo date('Y-m-d'); ?></p>
        </header>

        <!-- Report Table -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>Expense ID</th>
                    <th>Payment Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Paid Status</th>
                    <th>Head Manager ID</th>
                    <th>Finance Manager ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['expenseID']); ?></td>
                        <td><?php echo htmlspecialchars($row['expensePaymentDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['expenseDescription']); ?></td>
                        <td><?php echo htmlspecialchars($row['expenseType']); ?></td>
                        <td><?php echo number_format($row['expenseAmount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['expensePaymentMethod']); ?></td>
                        <td><?php echo $row['expensePaidStatus'] ? 'Paid' : 'Not Paid'; ?></td>
                        <td><?php echo htmlspecialchars($row['HmanagerID']); ?></td>
                        <td><?php echo htmlspecialchars($row['FmanagerID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Buttons -->
        <div class="buttons">
            <button onclick="window.print()">Print Report</button>
            <a href="financeM.php"><button class="back">Back</button></a>
        </div>
    </div>
</body>
</html>
