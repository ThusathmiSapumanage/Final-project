<?php
include "config.php"; // Include your database connection configuration

// Retrieve form data
$eventName = $_POST['eventName'];
$eventType = $_POST['eventType'];
$eventDate = !empty($_POST['eventDate']) ? $_POST['eventDate'] : NULL;
$eventStatus = $_POST['eventStatus'];
$nameTag = !empty($_FILES['nameTag']['name']) ? $_FILES['nameTag']['name'] : NULL;
$eventSchedule = !empty($_FILES['eventSchedule']['name']) ? $_FILES['eventSchedule']['name'] : NULL;
$managerID = $_POST['managerID'];
$hallID = $_POST['hallID'];
$clientID = $_POST['clientID'];
$eventStart = $_POST['eventStart'];
$eventEnd = $_POST['eventEnd'];

// Initialize file paths
$nameTagPath = NULL;
$eventSchedulePath = NULL;

// Handle file uploads
if (!empty($nameTag)) {
    $nameTagPath = 'uploads/' . basename($_FILES['nameTag']['name']);
    move_uploaded_file($_FILES['nameTag']['tmp_name'], $nameTagPath);
}

if (!empty($eventSchedule)) {
    $eventSchedulePath = 'uploads/' . basename($_FILES['eventSchedule']['name']);
    move_uploaded_file($_FILES['eventSchedule']['tmp_name'], $eventSchedulePath);
}

// SQL query to insert the event into the database
$sql = "INSERT INTO events (eventName, eventType, eventVisitDate, eventStatus, nameTagDesign, eventSchedule, EmanagerID, hallID, clientID, eventStart, eventEnd) 
        VALUES ('$eventName', '$eventType', " . 
        ($eventDate ? "'$eventDate'" : "NULL") . ", 
        '$eventStatus', " . 
        ($nameTagPath ? "'$nameTagPath'" : "NULL") . ", " . 
        ($eventSchedulePath ? "'$eventSchedulePath'" : "NULL") . ", 
        '$managerID', '$hallID', '$clientID', '$eventStart', '$eventEnd')";

        if ($conn->query($sql) === TRUE) {
            echo "Event added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        

$conn->close();
?>
