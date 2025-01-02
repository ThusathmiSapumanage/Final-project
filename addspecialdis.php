<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $discountID = mysqli_real_escape_string($conn, $_POST['discountID']);
    $eligibilityCriteria = mysqli_real_escape_string($conn, $_POST['eligibilityCriteria']);
    $validFrom = mysqli_real_escape_string($conn, $_POST['validFrom']);
    $validTill = mysqli_real_escape_string($conn, $_POST['validTill']);
    $specialReason = mysqli_real_escape_string($conn, $_POST['specialReason']);

    $sql = "INSERT INTO specialdiscount (SdiscountID, eligibilityCriteria, validFrom, validTill, specialDreason) 
            VALUES ('$discountID', '$eligibilityCriteria', '$validFrom', '$validTill', '$specialReason')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special discount added successfully!'); window.location.href = 'manageDiscount.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$discountID = isset($_GET['discountID']) ? $_GET['discountID'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Special Discount</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="discountID" value="<?php echo htmlspecialchars($discountID); ?>">
        <label>Eligibility Criteria:</label>
        <input type="text" name="eligibilityCriteria" required>
        <label>Valid From:</label>
        <input type="date" name="validFrom" required>
        <label>Valid Till:</label>
        <input type="date" name="validTill" required>
        <label>Reason:</label>
        <textarea name="specialReason" required></textarea>
        <button type="submit" name="submit">Add Special Discount</button>
    </form>
</body>
</html>
