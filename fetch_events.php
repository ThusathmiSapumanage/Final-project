<?php
include "config.php"; // Include your database connection configuration

// Query to fetch events
$sql = "SELECT eventID AS id, eventName AS title, eventStart AS start, eventEnd AS end FROM events";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Return JSON response
echo json_encode($events);

$conn->close();
?>
