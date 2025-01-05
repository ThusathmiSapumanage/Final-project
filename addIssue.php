<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $issueName = $_POST['issueName'];
    $issueDes = $_POST['issueDes'];

    // Validate ID and password from hiringstaff table
    $sql = "SELECT * FROM hiringstaff WHERE staffID = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Match the entered password with the staffPassword field in the database
        if ($user['staffPassword'] == $password) {
            // Escape special characters to avoid SQL errors
            $issueName = mysqli_real_escape_string($conn, $issueName);
            $issueDes = mysqli_real_escape_string($conn, $issueDes);

            // Insert the issue into the reportedissue table
            $sqlInsert = "INSERT INTO reportedissue (issueName, issueDes, PstaffID, issuePostedDate) 
                          VALUES ('$issueName', '$issueDes', '$id', CURDATE())";

            if (mysqli_query($conn, $sqlInsert)) {
                echo "<script>alert('Issue added successfully!'); window.location.href = 'manageIssues.php';</script>";
            } else {
                echo "<script>alert('Error adding issue: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid staff ID or user not found.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Issue</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        .content {
            background-color: #f1f1f1;
            width: 500px;
            padding: 30px;
            border-radius: 10px;
            margin: auto;
        }

        .form-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .sub-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .sub-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <main class="content">
            <header class="header">
                <h1>Report an Issue</h1>
            </header>

            <div class="form-wrapper">
                <h2>Add New Issue</h2>
                <form class="form" action="" method="POST">

                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id" placeholder="Enter your ID" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="form-group">
                        <label for="issueName">Issue Name:</label>
                        <input type="text" id="issueName" name="issueName" placeholder="Enter issue name" required>
                    </div>

                    <div class="form-group">
                        <label for="issueDes">Issue Description:</label>
                        <textarea id="issueDes" name="issueDes" placeholder="Describe the issue" required></textarea>
                    </div>

                    <button type="submit" class="sub-btn">Add Issue</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
