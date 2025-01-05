<?php
header('Content-Type: application/json');

include "config.php";

$sql = "SELECT 
            eventID as id, 
            eventName as title, 
            eventStart as start, 
            eventEnd as end, 
            eventType, 
            eventStatus, 
            ClientID, 
            EmanagerID, 
            hallID 
        FROM events";

$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);

$conn->close();
?>
