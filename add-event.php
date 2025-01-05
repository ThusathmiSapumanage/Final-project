<?php
header('Content-Type: application/json');
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['eventName'];
    $eventStart = $_POST['eventStart'];
    $eventEnd = $_POST['eventEnd'];
    $eventType = $_POST['eventType'];
    $eventStatus = $_POST['eventStatus'];
    $ClientID = intval($_POST['ClientID']);
    $EmanagerID = $_POST['EmanagerID'];
    $hallID = intval($_POST['hallID']);
    $eventVisitDate = $_POST['eventVisitDate'];

    // Insert the event into the database
    $stmt = $conn->prepare("INSERT INTO events (eventName, eventStart, eventEnd, eventType, eventStatus, ClientID, EmanagerID, hallID, eventVisitDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssisis", $eventName, $eventStart, $eventEnd, $eventType, $eventStatus, $ClientID, $EmanagerID, $hallID, $eventVisitDate);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add the event.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}

$conn->close();
?>
