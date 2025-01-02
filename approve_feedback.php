<?php
include "config.php";

$feedbackID = $_POST['feedbackID'];
$managerID = $_POST['managerID'];
$password = $_POST['password'];

// Validate manager credentials
$sql = "SELECT * FROM manager WHERE managerID = '$managerID' AND mPassword = '$password'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $updateQuery = "UPDATE feedback SET managerID = '$managerID' WHERE feedbackID = '$feedbackID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Feedback approved successfully!";
    } else {
        echo "Error approving feedback: " . mysqli_error($conn);
    }
} else {
    echo "Invalid manager credentials.";
}

mysqli_close($conn);
?>
