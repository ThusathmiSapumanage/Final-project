<?php
include "config.php";
session_start();

// Capture form data and sanitize it
$eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
$eventType = mysqli_real_escape_string($conn, $_POST['eventType']);
$eventVisitDate = mysqli_real_escape_string($conn, $_POST['eventDate']);
$eventStart = mysqli_real_escape_string($conn, $_POST['eventStart']);
$eventEnd = mysqli_real_escape_string($conn, $_POST['eventEnd']);
$eventStatus = mysqli_real_escape_string($conn, $_POST['eventStatus']);

// Insert new event
$sql = "INSERT INTO events (eventName, eventType, eventVisitDate, eventStart, eventEnd, eventStatus) 
        VALUES ('$eventName', '$eventType', '$eventVisitDate', '$eventStart', '$eventEnd', '$eventStatus')";

if (mysqli_query($conn, $sql)) {
    echo "Event added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

$conn->close();
?>
