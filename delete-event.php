<?php
header('Content-Type: application/json');
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $eventID = intval($_GET['id']);

    // Delete the event from the database
    $stmt = $conn->prepare("DELETE FROM events WHERE eventID = ?");
    $stmt->bind_param("i", $eventID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete the event.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}

$conn->close();
?>
