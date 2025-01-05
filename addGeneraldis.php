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
        echo "<script>alert('General discount added successfully!'); window.location.href = 'manageDiscounts.php';</script>";
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
    <link rel="stylesheet" href="addcommon.css">
    <style>
        .main-content {
            background-color: white;
        }
    </style>a
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Add General Discount</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" method="POST">
                        <input type="hidden" name="discountID" value="<?php echo htmlspecialchars($discountID); ?>">

                        <label for="minPaymentAmount">Min Payment Amount:</label>
                        <input type="number" id="minPaymentAmount" name="minPaymentAmount" step="0.01" required>

                        <label for="targetGroup">Target Group:</label>
                        <input type="text" id="targetGroup" name="targetGroup" required>

                        <label for="generalReason">Reason:</label>
                        <textarea id="generalReason" name="generalReason" rows="4" required></textarea>

                        <br>
                        <br>
                        <button class="sub-btn" type="submit" name="submit">Add General Discount</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
