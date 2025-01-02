<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $discountID = mysqli_real_escape_string($conn, $_POST['discountID']);
    $minPaymentAmount = mysqli_real_escape_string($conn, $_POST['minPaymentAmount']);
    $targetGroup = mysqli_real_escape_string($conn, $_POST['targetGroup']);
    $generalReason = mysqli_real_escape_string($conn, $_POST['generalReason']);

    $sql = "INSERT INTO generaldiscount (GdiscountID, minPaymentAmount, targetGroup, generalDreason) 
            VALUES ('$discountID', '$minPaymentAmount', '$targetGroup', '$generalReason')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('General discount added successfully!'); window.location.href = 'manageDiscount.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$discountID = isset($_GET['discountID']) ? $_GET['discountID'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add General Discount</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="discountID" value="<?php echo htmlspecialchars($discountID); ?>">
        <label>Min Payment Amount:</label>
        <input type="number" name="minPaymentAmount" step="0.01" required>
        <label>Target Group:</label>
        <input type="text" name="targetGroup" required>
        <label>Reason:</label>
        <textarea name="generalReason" required></textarea>
        <button type="submit" name="submit">Add General Discount</button>
    </form>
</body>
</html>
r