<?php
include "config.php";
session_start();

$clientID = $_SESSION['clientID'];
$eventID = isset($_POST['eventID']) ? $_POST['eventID'] : null;
$eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
$eventType = mysqli_real_escape_string($conn, $_POST['eventType']);
$eventStart = mysqli_real_escape_string($conn, $_POST['eventStart']);
$eventEnd = mysqli_real_escape_string($conn, $_POST['eventEnd']);
$hallID = mysqli_real_escape_string($conn, $_POST['hallID']);

if ($eventID) {
    // Update existing event
    $sql = "UPDATE events SET eventName='$eventName', eventType='$eventType', eventStart='$eventStart', 
            eventEnd='$eventEnd', hallID='$hallID' WHERE eventID='$eventID'";
} else {
    // Insert new event
    $sql = "INSERT INTO events (eventName, eventType, eventStart, eventEnd, hallID, ClientID) 
            VALUES ('$eventName', '$eventType', '$eventStart', '$eventEnd', '$hallID', '$clientID')";
}

if (mysqli_query($conn, $sql)) {
    echo $eventID ? "Event updated successfully!" : "Event added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
$conn->close();
?>
