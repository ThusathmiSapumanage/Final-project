<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "gaphq";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data from form
$name = $conn->real_escape_string($_POST['name']);
$company = $conn->real_escape_string($_POST['company']);
$designation = $conn->real_escape_string($_POST['designation']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$communication = $conn->real_escape_string($_POST['communication']);

// Handle file upload (if profile picture is updated)
$profilePicture = null;
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
    $profilePicture = 'uploads/' . basename($_FILES['profilePicture']['name']);
    move_uploaded_file($_FILES['profilePicture']['tmp_name'], $profilePicture);
}

// SQL to update customer data
if ($profilePicture) {
    $sql = "UPDATE Client SET 
                company = '$company',
                designation = '$designation',
                email = '$email',
                phone = '$phone',
                communication = '$communication',
                profile_picture = '$profilePicture'
            WHERE name = '$name'";
} else {
    $sql = "UPDATE client SET 
                company = '$company',
                designation = '$designation',
                email = '$email',
                phone = '$phone',
                communication = '$communication'
            WHERE name = '$name'";
}

if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
