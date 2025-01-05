<?php
include "config.php";

// Retrieve the staffID from the query string
$staffID = isset($_GET['staffID']) ? $_GET['staffID'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $eventCoverageCount = intval($_POST['eventCoverageCount']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    // Insert into `photographer` table
    $sql = "INSERT INTO photographer (PstaffID, eventCoverageCount, specialization) 
            VALUES ('$staffID', '$eventCoverageCount', '$specialization')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageStaff.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Photographer</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .container {
            display: flex;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 200px;
            background: #151515;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-sidebar .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .custom-sidebar .menu a:hover,
        .custom-sidebar .menu a.active {
            background: #fdb827;
            color: black;
        }

        .main-content {
            padding: 15px;
            background-color: #ffffff;
            width: 100%;
        }

        .header {
            margin-bottom: 20px;
        }

        .content-inner {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-box {
            margin-top: 20px;
        }

        .content-box h2 {
            text-align: center;
            color: #333;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form label {
            font-size: 14px;
            color: #333;
        }

        .form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        .form button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .form button:hover {
            background-color: #45a049;
        }

        .back-btn {
            padding: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .back-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php include 'header.php'; ?>

        <main class="main-content">
            <header class="header">
                <h1>Add Photographer</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Photographer Details</h2>
                    <form class="form" action="addPhotographer.php?staffID=<?php echo htmlspecialchars($staffID); ?>" method="post">
                        <label for="eventCoverageCount">Event Coverage Count:</label>
                        <input type="number" id="eventCoverageCount" name="eventCoverageCount" required>

                        <label for="specialization">Specialization:</label>
                        <input type="text" id="specialization" name="specialization" required>

                        <button class="sub-btn" type="submit" name="submit">Add Photographer</button>
                    </form>
                    <a href="addStaff.php"><button class="back-btn">Back</button></a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
