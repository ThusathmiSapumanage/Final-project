<?php
header('Content-Type: application/json');
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventID = intval($_POST['eventID']);
    $eventName = $_POST['eventName'];
    $eventStart = $_POST['eventStart'];
    $eventEnd = $_POST['eventEnd'];
    $eventType = $_POST['eventType'];
    $eventStatus = $_POST['eventStatus'];
    $ClientID = intval($_POST['ClientID']);
    $EmanagerID = $_POST['EmanagerID'];
    $hallID = intval($_POST['hallID']);
    $eventVisitDate = $_POST['eventVisitDate'];

    // Update the event in the database
    $stmt = $conn->prepare("UPDATE events SET eventName = ?, eventStart = ?, eventEnd = ?, eventType = ?, eventStatus = ?, ClientID = ?, EmanagerID = ?, hallID = ?, eventVisitDate = ? WHERE eventID = ?");
    $stmt->bind_param("sssssisisi", $eventName, $eventStart, $eventEnd, $eventType, $eventStatus, $ClientID, $EmanagerID, $hallID, $eventVisitDate, $eventID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update the event.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}

$conn->close();
?>
