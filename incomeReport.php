<?php
include 'config.php'; // Include your database connection

// Fetch all data from the payment table
$sql = "SELECT * FROM payment ORDER BY paymentDate ASC";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Report</title>
    <link rel="stylesheet" href="reportStyles.css">
</head>
<body>
    <div class="report-container">
        <header class="report-header">
            <h1>Payment Report</h1>
            <p>Date Generated: <?php echo date('Y-m-d'); ?></p>
        </header>
        
        <table class="report-table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount Payable</th>
                    <th>Payment Date</th>
                    <th>Client ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['paymentID']; ?></td>
                        <td><?php echo number_format($row['amountPayable'], 2); ?></td>
                        <td><?php echo $row['paymentDate']; ?></td>
                        <td><?php echo $row['clientID']; ?></td>
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
