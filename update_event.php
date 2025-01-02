<?php
include "config.php"; // Include your database connection configuration

// Retrieve form data
$eventId = $_POST['eventId'];
$eventName = $_POST['eventName'];
$eventType = $_POST['eventType'];
$eventDate = !empty($_POST['eventDate']) ? $_POST['eventDate'] : NULL; // Handle optional field
$eventStatus = $_POST['eventStatus'];
$nameTag = !empty($_FILES['nameTag']['name']) ? $_FILES['nameTag']['name'] : NULL; // Handle optional file
$eventSchedule = !empty($_FILES['eventSchedule']['name']) ? $_FILES['eventSchedule']['name'] : NULL; // Handle optional file
$managerID = $_POST['managerID'];
$hallID = $_POST['hallID'];
$clientID = $_POST['clientID'];
$eventStart = $_POST['eventStart'];
$eventEnd = $_POST['eventEnd'];

// Update SQL query
$sql = "UPDATE events 
        SET eventName='$eventName', 
            eventType='$eventType', 
            eventVisitDate=" . ($eventDate ? "'$eventDate'" : "NULL") . ", 
            eventStatus='$eventStatus', 
            EmanagerID='$managerID', 
            hallID='$hallID', 
            clientID='$clientID', 
            eventStart='$eventStart', 
            eventEnd='$eventEnd'";

$sql .= " WHERE eventID='$eventId'";

if ($conn->query($sql) === TRUE) {
    echo "Event updated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
