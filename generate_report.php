<?php
include 'config.php';

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fields'])) {
    $fields = $_POST['fields'];

    // Verify if any fields were selected
    if (empty($fields)) {
        echo "<script>alert('No fields selected. Please select fields to generate a report.'); window.location.href = 'report_form.php';</script>";
        exit;
    }

    // Select only primary keys and valid fields based on the class diagram connections
    $selectedFields = implode(", ", $fields);

    // Adjust the query to include only connected tables based on the class diagram
    $sql = "
        SELECT $selectedFields FROM (
            SELECT 
                paymentDate, 
                paymentMethod, 
                paymentStatus 
            FROM PaymentsTracking
            UNION ALL
            SELECT 
                expenseType, 
                expenseAmount, 
                expensePaymentMethod, 
                expensePaidStatus 
            FROM Expenses
            UNION ALL
            SELECT 
                clientName, 
                companyName, 
                communicationMethod 
            FROM Client
            UNION ALL
            SELECT 
                eventType, 
                eventName, 
                eventVisitDate 
            FROM Events
        ) as combined";

    $result = mysqli_query($conn, $sql);

    // Handle errors in query execution
    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }

    // Fetch and process data
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Generate the HTML report
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>Financial Report</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
                background-color: #f9f9f9;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            table, th, td {
                border: 1px solid #ccc;
            }
            th, td {
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #007BFF;
                color: white;
            }
            h2 {
                color: #333;
            }
            .print-button {
                margin-top: 20px;
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
        <h2>Generated Financial Report</h2>";

    // Display data in a table
    if (count($data) > 0) {
        echo "<table>
                <thead>
                    <tr>";

        // Generate table headers
        foreach (array_keys($data[0]) as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }

        echo "      </tr>
                </thead>
                <tbody>";

        // Populate table rows
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        echo "  </tbody>
            </table>";
    } else {
        echo "<p>No data found for the selected fields.</p>";
    }

    echo "<div class='print-button'>
            <button onclick='window.print()'>Print Report</button>
          </div>";

    echo "</body></html>";

} else {
    echo "<script>alert('Invalid request. Please try again.'); window.location.href = 'report_form.php';</script>";
    exit;
}
?>


--WAS DOING THE REPORTS