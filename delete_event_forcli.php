<?php
include "config.php";

$eventID = mysqli_real_escape_string($conn, $_POST['eventID']);

$sql = "DELETE FROM events WHERE eventID='$eventID'";
if (mysqli_query($conn, $sql)) {
    echo "Event deleted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

$conn->close();
?>
