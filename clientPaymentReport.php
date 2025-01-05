<?php
include 'config.php'; // Include database configuration

// SQL Query
$sql = "
    SELECT 
        c.clientName,
        c.companyName,
        c.cEmail,
        c.cPhoneNumber,
        cp.paymentID,
        cp.amountPayable,
        cp.paymentDate,
        cp.currency,
        dc.debitCardType,
        dc.debitCardNumber,
        dc.expiryDate,
        p.paypalAccountEmail,
        p.transactionTimestamp,
        p.transactionFee
    FROM client c
    LEFT JOIN clientpayment cp ON c.clientID = cp.clientID
    LEFT JOIN debitcard dc ON cp.paymentID = dc.DpaymentID
    LEFT JOIN paypal p ON cp.paymentID = p.PpaymentID
    ORDER BY cp.paymentDate DESC;";

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
    <title>Client Payment Report</title>
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
    <h1>Client Payment Report</h1>

    <?php if (count($data) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Payment ID</th>
                    <th>Amount Payable</th>
                    <th>Payment Date</th>
                    <th>Currency</th>
                    <th>Debit Card Type</th>
                    <th>Debit Card Number</th>
                    <th>Debit Card Expiry</th>
                    <th>Paypal Email</th>
                    <th>Paypal Timestamp</th>
                    <th>Transaction Fee</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['clientName']) ?></td>
                        <td><?= htmlspecialchars($row['companyName']) ?></td>
                        <td><?= htmlspecialchars($row['cEmail']) ?></td>
                        <td><?= htmlspecialchars($row['cPhoneNumber']) ?></td>
                        <td><?= htmlspecialchars($row['paymentID']) ?></td>
                        <td><?= htmlspecialchars($row['amountPayable']) ?></td>
                        <td><?= htmlspecialchars($row['paymentDate']) ?></td>
                        <td><?= htmlspecialchars($row['currency']) ?></td>
                        <td><?= htmlspecialchars($row['debitCardType']) ?></td>
                        <td><?= htmlspecialchars($row['debitCardNumber']) ?></td>
                        <td><?= htmlspecialchars($row['expiryDate']) ?></td>
                        <td><?= htmlspecialchars($row['paypalAccountEmail']) ?></td>
                        <td><?= htmlspecialchars($row['transactionTimestamp']) ?></td>
                        <td><?= htmlspecialchars($row['transactionFee']) ?></td>
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
