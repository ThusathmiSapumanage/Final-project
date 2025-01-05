<?php
header('Content-Type: application/json');

// Database connection
include "config.php";

// Initialize data array
$data = [
    'clients' => [],
    'managers' => [],
    'halls' => [],
];

// Fetch clients
$result = $conn->query("SELECT clientID, clientname AS clientName FROM client");
while ($row = $result->fetch_assoc()) {
    $data['clients'][] = $row;
}

// Fetch event managers
$result = $conn->query("SELECT managerID, mName FROM manager WHERE managerID LIKE 'EID%'");
while ($row = $result->fetch_assoc()) {
    $data['managers'][] = $row;
}

// Fetch halls
$result = $conn->query("SELECT hallID, hallName FROM hall");
while ($row = $result->fetch_assoc()) {
    $data['halls'][] = $row;
}

// Output data as JSON
echo json_encode($data);

// Close the database connection
$conn->close();
?>
