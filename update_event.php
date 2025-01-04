<?php
include "config.php"; // Include your database connection configuration

// Retrieve form data
$eventId = $_POST['eventId'];
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

// Update event in the `events` table
$sql = "UPDATE events SET eventName='$eventName', eventType='$eventType', eventVisitDate=" . 
       ($eventDate ? "'$eventDate'" : "NULL") . ", eventStatus='$eventStatus', 
       nameTagDesign=" . ($nameTag ? "'$nameTag'" : "NULL") . ", 
       eventSchedule=" . ($eventSchedule ? "'$eventSchedule'" : "NULL") . ", 
       EmanagerID='$managerID', hallID='$hallID', clientID='$clientID', 
       eventStart='$eventStart', eventEnd='$eventEnd' 
       WHERE eventID='$eventId'";

if (mysqli_query($conn, $sql)) {
    // Update add-ons in `eventaddons` table
    mysqli_query($conn, "DELETE FROM eventaddons WHERE eventID='$eventId'");
    foreach ($addons as $addonID) {
        $sqlAddon = "INSERT INTO eventaddons (eventID, addonID) VALUES ('$eventId', '$addonID')";
        mysqli_query($conn, $sqlAddon);
    }

    // Update add-ons in `clientaddons` table
    mysqli_query($conn, "DELETE FROM clientaddons WHERE clientID='$clientID'");
    foreach ($addons as $addonID) {
        $sqlClientAddon = "INSERT INTO clientaddons (clientID, addonID) VALUES ('$clientID', '$addonID')";
        mysqli_query($conn, $sqlClientAddon);
    }

    echo "Event updated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
