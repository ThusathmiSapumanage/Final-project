<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $resourceID = $_POST['resourceID'];
    $resourceName = $_POST['resourceName'];
    $resourceAllocationStatus = $_POST['resourceAllocationStatus'];
    $resourceDescription = $_POST['resourceDescription'];
    $managerID = $_POST['managerID'];

    // SQL query to insert data into the 'resource' table
    $sql = "INSERT INTO resources (resourceID, resourceName, resourceDescription, resourceAllocationStatus, HmanagerID) 
            VALUES ('$resourceID','$resourceName', '$resourceDescription', '$resourceAllocationStatus', '$managerID')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageResource.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch manager IDs for dropdown
$sql = "SELECT HmanagerID FROM headmanager";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Resource</title>
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
                    <img src="images/search-interface-symbol.png" alt="Search Icon">
                    <button>Search</button>
                </div>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Add Resource</h2>
                    <form class="form" action="addResource.php" method="post">

                        <label for ="resourceID">Resource ID</label>
                        <input type="text" id="resourceID" name="resourceID" required>

                        <label for="resourceName">Resource Name</label>
                        <input type="text" id="resourceName" name="resourceName" required>

                        <label for="resourceAllocationStatus">Allocation Status</label>
                        <select id="resourceAllocationStatus" name="resourceAllocationStatus" required>
                            <option value="Available">Available</option>
                            <option value="Allocated">Allocated</option>
                        </select></br>

                        <label for="resourceDescription">Description</label>
                        <textarea id="resourceDescription" name="resourceDescription" required></textarea>

                        </br>
                        <label for="managerID">Manager ID</label>
                        <select id="managerID" name="managerID" required>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['HmanagerID'] . "'>" . $row['HmanagerID'] . "</option>";
                                }
                            }
                            ?>
                        </select>

                        <br>
                        <button class="sub-btn" type="submit" name="submit">Add Resource</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
