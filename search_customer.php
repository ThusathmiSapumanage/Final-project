<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "gaphq";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Get search query
$name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'No name provided.']);
    exit;
}

// Search for customer by name
$sql = "SELECT * FROM client WHERE name LIKE '%$name%' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'name' => $customer['name'],
        'company' => $customer['company'],
        'designation' => $customer['designation'],
        'email' => $customer['email'],
        'phone' => $customer['phone'],
        'communication' => $customer['communication']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No customer found.']);
}

$conn->close();
?>
