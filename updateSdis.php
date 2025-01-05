<?php
include 'config.php';

// Fetch the special discount details
$id = $_GET['id'];
$sql = "SELECT * FROM discount d JOIN specialdiscount s ON d.discountID = s.SdiscountID WHERE d.discountID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form inputs
    $discountName = $_POST['discountName'];
    $discountType = $_POST['discountType'];
    $discountAmount = $_POST['discountAmount'];
    $eligibilityCriteria = $_POST['eligibilityCriteria'];
    $validFrom = $_POST['validFrom'];
    $validTill = $_POST['validTill'];
    $specialDReason = $_POST['specialDReason'];

    // Update query
    $sqlUpdate = "
        UPDATE discount d JOIN specialdiscount s ON d.discountID = s.SdiscountID 
        SET d.discountName = '$discountName', d.discountType = '$discountType', d.discountAmount = '$discountAmount',
            s.eligibilityCriteria = '$eligibilityCriteria', s.validFrom = '$validFrom', s.validTill = '$validTill', 
            s.specialDReason = '$specialDReason'
        WHERE d.discountID = '$id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        echo "<script>alert('Special Discount updated successfully!'); window.location.href='manageDiscounts.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Special Discount</title>
    <link rel="stylesheet" href="commonupdate.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Update Special Discount</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <form class="form" method="POST">
                        <label for="discountName">Discount Name:</label>
                        <input type="text" id="discountName" name="discountName" value="<?= htmlspecialchars($row['discountName']); ?>" required>

                        <label for="discountType">Discount Type:</label>
                        <select id="discountType" name="discountType" required>
                            <option value="General" <?= $row['discountType'] == 'General' ? 'selected' : ''; ?>>General</option>
                            <option value="Special" <?= $row['discountType'] == 'Special' ? 'selected' : ''; ?>>Special</option>
                        </select>

                        <label for="discountAmount">Discount Amount:</label>
                        <input type="number" id="discountAmount" name="discountAmount" value="<?= htmlspecialchars($row['discountAmount']); ?>" step="0.01" required>

                        <label for="eligibilityCriteria">Eligibility Criteria:</label>
                        <input type="text" id="eligibilityCriteria" name="eligibilityCriteria" value="<?= htmlspecialchars($row['eligibilityCriteria']); ?>" required>

                        <label for="validFrom">Valid From:</label>
                        <input type="date" id="validFrom" name="validFrom" value="<?= htmlspecialchars($row['validFrom']); ?>" required>

                        <label for="validTill">Valid Till:</label>
                        <input type="date" id="validTill" name="validTill" value="<?= htmlspecialchars($row['validTill']); ?>" required>

                        <label for="specialDReason">Reason:</label>
                        <textarea id="specialDReason" name="specialDReason" rows="4" required><?= htmlspecialchars($row['specialDReason']); ?></textarea>

                        <br>
                        <br>
                        <button class="sub-btn" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
