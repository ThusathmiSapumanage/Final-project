<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedbackID = $_POST['feedbackID'];

    $sql = "DELETE FROM feedback WHERE feedbackID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedbackID);

    if ($stmt->execute()) {
        echo "Feedback deleted successfully.";
    } else {
        echo "Failed to delete feedback.";
    }

    $stmt->close();
    $conn->close();
}
?>
