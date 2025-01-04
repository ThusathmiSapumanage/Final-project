<?php
include "config.php"; // Include your database connection configuration

$eventId = isset($_GET['eventId']) ? $_GET['eventId'] : null;

// Fetch all add-ons
$sql = "SELECT * FROM addon";
$result = mysqli_query($conn, $sql);

$selectedAddons = [];
if ($eventId) {
    $addonQuery = "SELECT addonID FROM eventaddons WHERE eventID='$eventId'";
    $addonResult = mysqli_query($conn, $addonQuery);
    while ($row = mysqli_fetch_assoc($addonResult)) {
        $selectedAddons[] = $row['addonID'];
    }
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $checked = in_array($row['addonID'], $selectedAddons) ? "checked" : "";
        echo "<label><input type='checkbox' name='addons[]' value='" . $row['addonID'] . "' $checked> " . $row['description'] . "</label><br>";
    }
} else {
    echo "No add-ons available.";
}

$conn->close();
?>
