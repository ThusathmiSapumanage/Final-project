<?php
include "config.php"; // Include your database connection configuration

// Retrieve event ID
$eventId = $_POST['id'];

// Delete add-ons from `eventaddons` and `clientaddons` tables
$sqlDeleteEventAddons = "DELETE FROM eventaddons WHERE eventID='$eventId'";
$sqlDeleteClientAddons = "DELETE FROM clientaddons WHERE addonID IN (SELECT addonID FROM eventaddons WHERE eventID='$eventId')";

mysqli_query($conn, $sqlDeleteEventAddons);
mysqli_query($conn, $sqlDeleteClientAddons);

// Delete event from the `events` table
$sql = "DELETE FROM events WHERE eventID='$eventId'";

if (mysqli_query($conn, $sql)) {
    echo "Event deleted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
