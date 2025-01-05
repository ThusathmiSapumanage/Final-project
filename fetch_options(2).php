<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set Content Type
header('Content-Type: application/json');

// Database connection
include "config.php";

// Check if connection was successful
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Initialize output arrays
$clients = [];
$managers = [];
$halls = [];

// Fetch clients
$result = $conn->query("SELECT clientID, clientname AS clientName FROM client");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching clients: ' . $conn->error]);
    exit;
}

// Fetch event managers
$result = $conn->query("SELECT managerID, mName FROM manager WHERE managerID LIKE 'EID%'");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $managers[] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching managers: ' . $conn->error]);
    exit;
}

// Fetch halls
$result = $conn->query("SELECT hallID, hallName FROM hall");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $halls[] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching halls: ' . $conn->error]);
    exit;
}

// Output JSON
echo json_encode([
    'clients' => $clients,
    'managers' => $managers,
    'halls' => $halls,
]);

// Close the database connection
$conn->close();
?>
