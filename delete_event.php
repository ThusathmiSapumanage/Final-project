<?php
include "config.php"; // Include your database connection configuration

// Retrieve event ID
$eventId = $_POST['id'];

// Delete query
$sql = "DELETE FROM events WHERE eventID='$eventId'";

if ($conn->query($sql) === TRUE) {
    echo "Event deleted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
