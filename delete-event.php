<?php
// Include database connection
include 'config.php';

header('Content-Type: application/json');

try {
    // Decode the JSON payload sent from the frontend
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if eventID is provided
    if (!isset($data['eventID']) || empty($data['eventID'])) {
        echo json_encode(['success' => false, 'error' => 'Missing or invalid eventID']);
        exit;
    }

    $eventID = $data['eventID'];

    // SQL to delete the event
    $sql = "DELETE FROM events WHERE eventID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete the event']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
