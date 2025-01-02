-- message to self : check this today!! smt is seriosuly wrong. fix it!! also check css of other codes. you said you will later!


<?php
include 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fields'])) {
    $fields = $_POST['fields'];

    // Check if any fields were selected
    if (empty($fields)) {
        echo "<script>alert('No fields selected. Please select fields to generate a report.'); window.location.href = 'report_form.php';</script>";
        exit;
    }

    // Create the SQL query dynamically based on selected fields
    $selectedFields = implode(", ", $fields);

    $sql = "SELECT $selectedFields FROM (
                SELECT 
                    paymentID, 
                    amountPayable, 
                    paymentDate, 
                    currency, 
                    FmanagerID, 
                    clientID,
                    NULL AS hallID, 
                    NULL AS hallName, 
                    NULL AS addonID,
                    NULL AS description 
                FROM clientpayment
                UNION ALL
                SELECT 
                    clientID, 
                    NULL AS amountPayable, 
                    NULL AS paymentDate, 
                    NULL AS currency, 
                    HmanagerID, 
                    clientName,
                    NULL AS hallID, 
                    NULL AS hallName, 
                    NULL AS addonID,
                    NULL AS description 
                FROM client
                UNION ALL
                SELECT 
                    NULL AS paymentID, 
                    NULL AS amountPayable, 
                    NULL AS paymentDate, 
                    NULL AS currency, 
                    managerID, 
                    NULL AS clientID,
                    hallID, 
                    hallName, 
                    NULL AS addonID,
                    NULL AS description 
                FROM hall
                UNION ALL
                SELECT 
                    NULL AS paymentID, 
                    NULL AS amountPayable, 
                    NULL AS paymentDate, 
                    NULL AS currency, 
                    EmanagerID, 
                    NULL AS clientID,
                    NULL AS hallID, 
                    NULL AS hallName, 
                    addonID,
                    description 
                FROM addon
            ) as combined";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }

    // Fetch the data
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Generate the report in HTML
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>Generated Report</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
                background-color: #f4f4f9;
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
        <h2>Generated Report</h2>";

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

        // Generate table rows
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
    echo "<script>alert('No fields selected. Please go back and select fields to generate a report.'); window.location.href = 'report_form.php';</script>";
    exit;
}
?>
