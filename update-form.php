<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "gaphq";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get clientID from URL
$clientID = $_GET['clientID'];

// Fetch client data from the database
$sql = "SELECT * FROM client WHERE clientID = $clientID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
} else {
    echo "Client not found.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client Information</title>
</head>
<body>
    <h1>Update Client Information</h1>
    <form action="process_update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="clientID" value="<?php echo $client['id']; ?>">

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $client['clientname']; ?>" required>

        <label for="company">Company Name:</label>
        <input type="text" id="company" name="company" value="<?php echo $client['companyName']; ?>" required>

        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation" value="<?php echo $client['cDesignation']; ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $client['cPhoneNumber']; ?>" required>

        <label for="communication">Preferred Communication Method:</label>
        <select id="communication" name="communication" required>
            <option value="email" <?php if ($client['communicationMethod'] == 'email') echo 'selected'; ?>>Email</option>
            <option value="phone" <?php if ($client['communicationMethod'] == 'phone') echo 'selected'; ?>>Phone</option>
            <option value="text" <?php if ($client['communicationMethod'] == 'text') echo 'selected'; ?>>Text Message</option>
        </select>

        <label for="profilePicture">Update Profile Picture (optional):</label>
        <input type="file" id="profilePicture" name="profilePicture" accept="image/*">

        <button type="submit">Update Information</button>
    </form>
</body>
</html>