<?php

include "config.php";

$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

$sql = "INSERT INTO events (title, start, end) VALUES ('$title', '$start', '$end')";
if ($conn->query($sql) === TRUE) {
    echo "New event added!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
