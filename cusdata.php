<?php
// Establish a connection to your database
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "gaphq"; // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $companyName = $_POST['company'];
    $communicationMethod = $_POST['communication'];
    $phoneNumber = $_POST['phone'];
    $designation = $_POST['designation'];
    $clientName = $_POST['name'];

    // Handle Profile Picture upload
    $target_dir = "uploads/"; // Directory where images will be uploaded
    $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image
    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] == 0) {
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Check file size (example: max 2MB)
        if ($_FILES["profilePicture"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        // Attempt to upload the file
        //if (!move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
        //    echo "Sorry, there was an error uploading your file.";
        //    exit;
        //}
    } else {
        echo "No file uploaded or there was an error with the file upload.";
        exit;
    }

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO client (companyName, communicationMethod, cPhoneNumber, cDesignation, clientname, cProfilePicture) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $companyName, $communicationMethod, $phoneNumber, $designation, $clientName, $target_file);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
