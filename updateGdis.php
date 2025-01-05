<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM discount d JOIN generaldiscount g ON d.discountID = g.GdiscountID WHERE d.discountID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discountName = $_POST['discountName'];
    $discountType = $_POST['discountType'];
    $discountAmount = $_POST['discountAmount'];
    $minPaymentAmount = $_POST['minPaymentAmount'];
    $targetGroup = $_POST['targetGroup'];
    $generalDreason = $_POST['generalDreason'];

    $sqlUpdate = "
        UPDATE discount d JOIN generaldiscount g ON d.discountID = g.GdiscountID 
        SET d.discountName = '$discountName', d.discountType = '$discountType', d.discountAmount = '$discountAmount',
            g.minPaymentAmount = '$minPaymentAmount', g.targetGroup = '$targetGroup', g.generalDreason = '$generalDreason'
        WHERE d.discountID = '$id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        echo "<script>alert('General Discount updated successfully!'); window.location.href='manageDiscounts.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update General Discount</title>
    <link rel="stylesheet" href="commonupdate.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1 style = 'color: black;'>Update General Discount</h1>
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

                        <label for="minPaymentAmount">Minimum Payment Amount:</label>
                        <input type="number" id="minPaymentAmount" name="minPaymentAmount" value="<?= htmlspecialchars($row['minPaymentAmount']); ?>" step="0.01" required>

                        <label for="targetGroup">Target Group:</label>
                        <input type="text" id="targetGroup" name="targetGroup" value="<?= htmlspecialchars($row['targetGroup']); ?>" required>

                        <label for="generalDreason">Reason:</label>
                        <textarea id="generalDreason" name="generalDreason" rows="4" required><?= htmlspecialchars($row['generalDreason']); ?></textarea>

                        <button class="sub-btn" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
