<?php
// Establish a connection to your database
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "gaphq"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form values
    $eventName = trim($_POST['eventName']);
    $eventType = trim($_POST['eventType']);
    $eventVisitDate = trim($_POST['eventDate']);
    $eventStart = trim($_POST['eventStart']);
    $eventEnd = trim($_POST['eventEnd']);
    $eventStatus = trim($_POST['eventStatus']);

    // Validate that all fields are filled
    if (empty($eventName) || empty($eventType) || empty($eventVisitDate) || empty($eventStart) || empty($eventEnd) || empty($eventStatus)) {
        echo "All fields are required.";
        exit;
    }

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO events (eventName, eventType, eventVisitDate, eventStart, eventEnd, eventStatus) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $eventName, $eventType, $eventVisitDate, $eventStart, $eventEnd, $eventStatus);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Event added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
