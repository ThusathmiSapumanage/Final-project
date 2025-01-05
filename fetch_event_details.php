<?php
include "config.php"; // Include database connection configuration

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    // Query to fetch event details
    $sql = "
        SELECT 
            e.eventID, 
            e.eventName, 
            e.eventType, 
            e.eventStatus, 
            e.eventStart, 
            e.eventEnd, 
            e.ClientID, 
            e.EmanagerID, 
            e.hallID
        FROM events e
        WHERE e.eventID = '$eventID'
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $eventDetails = mysqli_fetch_assoc($result);
        echo json_encode($eventDetails);
    } else {
        echo json_encode(['error' => 'No event found']);
    }
} else {
    echo json_encode(['error' => 'No event ID provided']);
}

mysqli_close($conn);
?>
