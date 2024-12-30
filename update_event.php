<?php

include "config.php";

$id = $_POST['id'];
$start = $_POST['start'];
$end = $_POST['end'];

$sql = "UPDATE events SET start = '$start', end = '$end' WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Event updated!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
