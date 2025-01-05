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
        echo "<script>alert('Special discount added successfully!'); window.location.href = 'manageDiscounts.php';</script>";
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
    <link rel="stylesheet" href="addcommon.css">
    <style>
        .main-content {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Add Special Discount</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" method="POST">
                        <input type="hidden" name="discountID" value="<?php echo htmlspecialchars($discountID); ?>">

                        <label for="eligibilityCriteria">Eligibility Criteria:</label>
                        <input type="text" id="eligibilityCriteria" name="eligibilityCriteria" required>

                        <label for="validFrom">Valid From:</label>
                        <input type="date" id="validFrom" name="validFrom" required>

                        <label for="validTill">Valid Till:</label>
                        <input type="date" id="validTill" name="validTill" required>

                        <label for="specialReason">Reason:</label>
                        <textarea id="specialReason" name="specialReason" rows="4" required></textarea>

                        <br>
                        <br>
                        <button class="sub-btn" type="submit" name="submit">Add Special Discount</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
