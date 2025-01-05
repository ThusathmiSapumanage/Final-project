<?php
// Database connection
$host = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "gaphq"; // Your database name

$conn = new mysqli($host, $username, $password, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $eventName = $conn->real_escape_string($_POST['eventName']);
    $eventType = $conn->real_escape_string($_POST['eventType']);
    $eventStatus = $conn->real_escape_string($_POST['eventStatus']);
    $eventVisitDate = $conn->real_escape_string($_POST['eventVisitDate']);
    $eventID = isset($_POST['eventID']) ? $conn->real_escape_string($_POST['eventID']) : null;
    $eventStart = isset($_POST['eventStart']) ? $conn->real_escape_string($_POST['eventStart']) : null;
    $eventEnd = isset($_POST['eventEnd']) ? $conn->real_escape_string($_POST['eventEnd']) : null;


    // File handling for nameTagDesign and eventSchedule
    $nameTagDesign = null;
    if (isset($_FILES['nameTagDesign']) && $_FILES['nameTagDesign']['error'] == 0) {
        $nameTagDesign = 'uploads/' . basename($_FILES['nameTagDesign']['name']);
        move_uploaded_file($_FILES['nameTagDesign']['tmp_name'], $nameTagDesign);
    }

    $eventSchedule = null;
    if (isset($_FILES['eventSchedule']) && $_FILES['eventSchedule']['error'] == 0) {
        $eventSchedule = 'uploads/' . basename($_FILES['eventSchedule']['name']);
        move_uploaded_file($_FILES['eventSchedule']['tmp_name'], $eventSchedule);
    }

    // SQL to insert the data into the events table
    $sql = "INSERT INTO events (eventName, eventType, eventVisitDate, nameTagDesign, eventSchedule, eventID, eventStart, eventEnd, eventStatus)
            VALUES ('$eventName', '$eventType', '$eventVisitDate', '$nameTagDesign', '$eventSchedule', '$eventID', '$eventStart', '$eventEnd', '$eventStatus')";

    if ($conn->query($sql) === TRUE) {
        echo "New event record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
