<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaphq";

// Create connection
<<<<<<< HEAD
$conn = mysqli_connect($servername, $username, $password, $dbname);
=======
$conn = mysqli_connect($servername, $username, $password, $dbname, 3306);
>>>>>>> dbd4bb534d78f772be0f13c4cee8fe94f5984e75

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
