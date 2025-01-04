<?php
// Database connection
$servername = "localhost";
$username = "root";  // XAMPP default username
$password = "";      // XAMPP default password
$database = "your_database";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profilePicture = $_FILES['profilePicture'];
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($profilePicture["name"]);

    // Upload profile picture
    if (move_uploaded_file($profilePicture["tmp_name"], $uploadFile)) {
        $cProfilePicture = $uploadFile;
    } else {
        echo "Error uploading profile picture.";
        exit;
    }

    // Retrieve and sanitize form data
    $clientname = $conn->real_escape_string($_POST['name']);
    $companyName = $conn->real_escape_string($_POST['company']);
    $cDesignation = $conn->real_escape_string($_POST['designation']);
    $cPhoneNumber = $conn->real_escape_string($_POST['phone']);
    $communicationMethod = $conn->real_escape_string($_POST['communication']);

    // Insert data into the 'client' table
    $sql = "INSERT INTO client (companyName, communicationMethod, cPhoneNumber, cDesignation, clientname, cProfilePicture)
            VALUES ('$companyName', '$communicationMethod', '$cPhoneNumber', '$cDesignation', '$clientname', '$cProfilePicture')";

    if ($conn->query($sql) === TRUE) {
        echo "Client data added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
