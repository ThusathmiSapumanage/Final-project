<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = $_POST['fields'];

    // Database connection
    include "config.php";

    // Construct the SQL query
    $sql = "SELECT 
    p.paymentID, 
    p.amountPayable, 
    p.paymentDate, 
    c.clientID, 
    c.cName, 
    c.cPhoneNumber, 
    c.communicationMethod, 
    c.companyName, 
    c.cEmail 
FROM payment p
JOIN cusprofile c ON p.clientID = c.clientID";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        foreach ($fields as $field) {
            echo "<th>$field</th>";
        }
        echo "</tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<td>" . $row[$field] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
}
?>
