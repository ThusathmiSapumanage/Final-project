<?php

include "config.php";

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = array();
while ($row = $result->fetch_assoc()) {
    $events[] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end']
    );
}
echo json_encode($events);
$conn->close();
?>
