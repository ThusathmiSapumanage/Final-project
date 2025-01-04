<?php
include 'config.php'; // Database connection

$query = "SELECT hallID, hallName FROM hall";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['hallID'] . "'>" . $row['hallName'] . "</option>";
    }
} else {
    echo "<option value=''>No halls available</option>";
}

mysqli_close($conn);
?>
