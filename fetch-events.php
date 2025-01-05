<?php
header('Content-Type: application/json');
include 'config.php';

$sql = "SELECT 
            eventID, eventName, eventStart, eventEnd, eventVisitDate, eventType, eventStatus, ClientID, EmanagerID, hallID 
        FROM events";
$result = mysqli_query($conn, $sql);

$events = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = [
            'id' => $row['eventID'],
            'title' => $row['eventName'],
            'start' => $row['eventStart'],
            'end' => $row['eventEnd'],
            'eventVisitDate' => $row['eventVisitDate'],
            'eventType' => $row['eventType'],
            'eventStatus' => $row['eventStatus'],
            'ClientID' => $row['ClientID'],
            'EmanagerID' => $row['EmanagerID'],
            'hallID' => $row['hallID']
        ];
    }
}

echo json_encode($events);
?>
