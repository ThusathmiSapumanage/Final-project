<?php

include "config.php";

$rID = isset($_GET['id']) ? $_GET['id'] : ""; // Assume resourceID is a string

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rID = $_POST['rID'];
    $rname = $_POST['rname'];
    $allocation = $_POST['allocation'];
    $des = $_POST['des'];
    $headmanager = $_POST['headmanagerID'];

    $sql = "UPDATE resources
            SET resourceName = ?, 
                resourceDescription = ?,
                resourceAllocationStatus = ?,
                HmanagerID = ?
            WHERE resourceID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $rname, $des, $allocation, $headmanager, $rID);

        if ($stmt->execute()) {
            echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
            echo "<script>window.location.href = 'manageResource.php';</script>";
            exit;
        } else {
            echo "Error updating resource: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$rname = $allocation = $des = $headmanager = "";

if (!empty($rID)) {
    $sql2 = "SELECT * FROM resources WHERE resourceID = ?";
    if ($stmt2 = $conn->prepare($sql2)) {
        $stmt2->bind_param("s", $rID);
        $stmt2->execute();
        $result = $stmt2->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rname = $row['resourceName'];
            $allocation = $row['resourceAllocationStatus'];
            $des = $row['resourceDescription'];
            $headmanager = $row['HmanagerID'];
        }

        $stmt2->close();
    }
}

$sql3 = "SELECT hmanagerID FROM headmanager";
$result2 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Resources </title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Resource Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="images/search-interface-symbol.png" alt="Search">
                        <button>Search</button>
                    </div>
                </header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Resources</h2>
                        <form class="form" action="updateResource.php" method="post">
                            <!-- Hidden field for resource ID -->
                            <input type="hidden" name="rID" value="<?php echo htmlspecialchars($rID); ?>">

                            <label for="rname">Resource Name</label>
                            <input type="text" name="rname" value="<?php echo htmlspecialchars($rname); ?>" required>

                            <label for="allocation">Allocation Status</label>
                            <select name="allocation" required>
                                <option value="Available" <?php echo ($allocation == "Available") ? "selected" : ""; ?>>Available</option>
                                <option value="Unavailable" <?php echo ($allocation == "Unavailable") ? "selected" : ""; ?>>Unavailable</option>
                            </select>

                            <label for="des">Description</label>
                            <input type="text" name="des" value="<?php echo htmlspecialchars($des); ?>" required>

                            <label for="headmanagerID">Head Manager ID</label>
                            <select name="headmanagerID" required>
                                <option value="">Select Head Manager</option>
                                <?php
                                if ($result2 && mysqli_num_rows($result2) > 0) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $selected = ($row2['hmanagerID'] == $headmanager) ? "selected" : "";
                                        echo "<option value='{$row2['hmanagerID']}' $selected>{$row2['hmanagerID']}</option>";
                                    }
                                }
                                ?>
                            </select>
                            <br>
                            <button class="sub-btn" type="submit" name="submit" style="background-color: #555; color: black;">Update Resource</button>
                        </form>

                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
