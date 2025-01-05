<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventStart = $_POST['eventStart'];
    $eventEnd = $_POST['eventEnd'];
    $eventVisitDate = $_POST['eventVisitDate'];
    $eventType = $_POST['eventType'];
    $eventStatus = $_POST['eventStatus'];
    $ClientID = $_POST['ClientID'];
    $EmanagerID = $_POST['EmanagerID'];
    $hallID = $_POST['hallID'];

    $sql = "UPDATE events 
            SET eventName = ?, eventStart = ?, eventEnd = ?, eventVisitDate = ?, eventType = ?, eventStatus = ?, ClientID = ?, EmanagerID = ?, hallID = ? 
            WHERE eventID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssisii', $eventName, $eventStart, $eventEnd, $eventVisitDate, $eventType, $eventStatus, $ClientID, $EmanagerID, $hallID, $eventID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
}
?>
