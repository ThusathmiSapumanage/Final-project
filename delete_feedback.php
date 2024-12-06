<?php

include "config.php"; // Include database configuration

if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM feedback WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        //echo "<script>alert('Feedback deleted successfully! Redirecting to feedback page...');</script>";
        echo "<script>window.location.href = 'feedback.php';</script>";
    } else {
        echo "Error deleting record: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "No Data received";
}

mysqli_close($conn);

?>
