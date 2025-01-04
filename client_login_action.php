<?php
session_start();
include 'config.php'; // Database connection

// Check if email and password are submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch the client with the entered email
    $query = "SELECT clientID, clientPass FROM client WHERE cEmail = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $client = mysqli_fetch_assoc($result);

        // Verify the password
        if ($password == $client['clientPass']) { // Change to password_verify if using hashed passwords
            // Set session variables
            $_SESSION['clientID'] = $client['clientID'];

            // Redirect to calendar page
            header("Location: calendar-try.php");
            exit;
        } else {
            header("Location: client_login.php?error=Invalid password.");
            exit;
        }
    } else {
        header("Location: client_login.php?error=Email not found.");
        exit;
    }
} else {
    header("Location: client_login.php");
    exit;
}
?>
