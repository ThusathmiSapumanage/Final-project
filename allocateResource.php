<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photographerID = $_POST['photographerID'];
    $resourceID = $_POST['resourceID'];

    // Insert into the allocation table
    $sql = "INSERT INTO photographerresources(PstaffID, resourceID) 
            VALUES ('$photographerID', '$resourceID')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Resource allocated successfully!'); window.location.href = 'manageStaff.php';</script>";
    } else {
        echo "<script>alert('Error allocating resource: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Allocate Resource</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .custom-sidebar {
    width: 250px;
    background: #151515;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    scrollbar-width: none;
}

.custom-sidebar::-webkit-scrollbar {
    display: none;
}

.custom-sidebar .logo img {
    display: block;
    margin: 0 auto 20px;
    max-width: 80%;
}

.custom-sidebar .menu {
    padding: 0;
    margin: 0;
    list-style: none;
}

.custom-sidebar .menu a {
    display: block;
    color: white;
    padding: 15px;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: background 0.3s;
}

.custom-sidebar .menu a.active,
.custom-sidebar .menu a:hover {
    background: #fdb827;
    color: black;
}

.custom-sidebar .dropdown-menu {
    display: none;
    padding-left: 15px;
    list-style: none;
    margin: 0;
}

.custom-sidebar .dropdown:hover .dropdown-menu {
    display: block;
}

.custom-sidebar .settings {
    margin-top: 20px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
}

.custom-sidebar .settings img {
    width: 20px;
    margin-right: 5px;
}


    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        margin-left: 200px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .back-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;a
    }

    .back-btn:hover {
        background-color: #5a6268;
    }
</style>
</head>
<body>
    <div class="container">
        <?php include 'header.php' ?>
        <h1>Allocate Resource</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="photographerID">Photographer ID:</label>
                <input type="text" id="photographerID" name="photographerID" value="<?php echo htmlspecialchars($_GET['photographerID']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="resourceID">Select Resource:</label>
                <select id="resourceID" name="resourceID" required>
                    <?php
                    $sql = "SELECT resourceID, resourceName FROM resources";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['resourceID']) . "'>" . htmlspecialchars($row['resourceID']) . " - " . htmlspecialchars($row['resourceName']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn submit-btn">Allocate Resource</button>
        </form>
        <button class="back-btn" onclick="window.location.href = 'manageStaff.php';">Back</button>
    </div>
</body>
</html>
