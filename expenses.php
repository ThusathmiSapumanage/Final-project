<?php
include 'config.php'; // Database connection

// Fetch combined data, grouping by date
$sql = "
    SELECT 
        date, 
        SUM(income) AS income, 
        SUM(expense) AS expense
    FROM (
        SELECT 
            paymentDate AS date, 
            SUM(amountPayable) AS income, 
            NULL AS expense
        FROM payment
        GROUP BY paymentDate
        UNION ALL
        SELECT 
            expenseDate AS date, 
            NULL AS income, 
            SUM(expenseAmount) AS expense
        FROM expenses
        GROUP BY expenseDate
    ) combined
    GROUP BY date
    ORDER BY date ASC
";

$result = mysqli_query($conn, $sql);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Format data for Chart.js
$response = [
    'dates' => array_column($data, 'date'),
    'income' => array_column($data, 'income'),
    'expenses' => array_column($data, 'expense'),
    'tableData' => $data
];

header('Content-Type: application/json');
echo json_encode($response);
?>
