<?php
include 'config.php';
$sql = "SELECT eventID, eventName, eventStart, eventEnd FROM events";
$result = mysqli_query($conn, $sql);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        'id' => $row['eventID'],
        'title' => $row['eventName'],
        'start' => $row['eventStart'],
        'end' => $row['eventEnd']
    ];
}
echo json_encode($events);
$conn->close();
?>
