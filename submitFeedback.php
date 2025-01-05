<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaphq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get feedback data from the POST request
$feedbackName = $_POST['feedbackName'];
$feedbackDescription = $_POST['feedbackDescription'];

$feedbackDate = date("Y-m-d H:i:s"); // Automatically capture the current date and time

// Prepare the SQL query to insert feedback into the table
$sql = "INSERT INTO feedback (feedbackName, feedbackDescription, feedbackDate) 
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $feedbackName, $feedbackDescription, $feedbackDate);

if ($stmt->execute()) {
    echo "Feedback submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
