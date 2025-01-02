<?php
include 'config.php';

function getOptions($query) {
    global $conn;
    $result = $conn->query($query);
    if (!$result) {
        error_log('Query failed: ' . $conn->error); // Log error to server logs
        return '<option value="">Error loading options</option>';
    }
    $options = '';
    while ($row = $result->fetch_assoc()) {
        $value = current($row); // Get the first column's value
        $options .= "<option value='{$value}'>{$value}</option>";
    }
    return $options;
}

$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type === 'manager') {
    echo getOptions("SELECT EmanagerID FROM EventManager");
} elseif ($type === 'hall') {
    echo getOptions("SELECT hallID FROM Hall");
} elseif ($type === 'client') {
    echo getOptions("SELECT clientID FROM Client");
} else {
    echo '<option value="">Invalid type specified</option>';
}
?>
