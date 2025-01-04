<?php
include "config.php"; // Include your database connection configuration

// Retrieve form data
$eventName = $_POST['eventName'];
$eventType = $_POST['eventType'];
$eventDate = !empty($_POST['eventDate']) ? $_POST['eventDate'] : NULL;
$eventStatus = $_POST['eventStatus'];
$managerID = $_POST['managerID'];
$hallID = $_POST['hallID'];
$clientID = $_POST['clientID'];
$eventStart = $_POST['eventStart'];
$eventEnd = $_POST['eventEnd'];
$addons = isset($_POST['addons']) ? $_POST['addons'] : [];

// Handle file uploads
$nameTag = $_FILES['nameTag']['name'] ? 'uploads/' . basename($_FILES['nameTag']['name']) : NULL;
$eventSchedule = $_FILES['eventSchedule']['name'] ? 'uploads/' . basename($_FILES['eventSchedule']['name']) : NULL;

if ($nameTag) move_uploaded_file($_FILES['nameTag']['tmp_name'], $nameTag);
if ($eventSchedule) move_uploaded_file($_FILES['eventSchedule']['tmp_name'], $eventSchedule);

// Insert event into the `events` table
$sql = "INSERT INTO events (eventName, eventType, eventVisitDate, eventStatus, nameTagDesign, eventSchedule, EmanagerID, hallID, clientID, eventStart, eventEnd) 
        VALUES ('$eventName', '$eventType', " . ($eventDate ? "'$eventDate'" : "NULL") . ", '$eventStatus', " .
        ($nameTag ? "'$nameTag'" : "NULL") . ", " . ($eventSchedule ? "'$eventSchedule'" : "NULL") . ", '$managerID', '$hallID', '$clientID', '$eventStart', '$eventEnd')";

if (mysqli_query($conn, $sql)) {
    $eventID = mysqli_insert_id($conn);

    // Insert add-ons into `eventaddons` table
    foreach ($addons as $addonID) {
        $sqlAddon = "INSERT INTO eventaddons (eventID, addonID) VALUES ('$eventID', '$addonID')";
        mysqli_query($conn, $sqlAddon);
    }

    // Insert add-ons into `clientaddons` table
    foreach ($addons as $addonID) {
        $sqlClientAddon = "INSERT INTO clientaddons (clientID, addonID) VALUES ('$clientID', '$addonID')";
        mysqli_query($conn, $sqlClientAddon);
    }

    echo "Event added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
