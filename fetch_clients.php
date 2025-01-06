<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "gaphq";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode([]));
}

$query = $conn->real_escape_string($_GET['query']);

$sql = "SELECT clientID, name FROM clients WHERE name LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

$clients = [];
while ($row = $result->fetch_assoc()) {
    $clients[] = $row;
}

echo json_encode($clients);
$conn->close();
?>
