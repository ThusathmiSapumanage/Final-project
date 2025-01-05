<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaphq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search term (eventID)
$searchTerm = isset($_GET['eventID']) ? $_GET['eventID'] : '';

// SQL to fetch events, filter by eventID if provided
$sql = "SELECT eventID, eventType, eventName FROM events WHERE eventID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
