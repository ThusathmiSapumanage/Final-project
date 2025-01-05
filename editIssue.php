<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerID = $_POST['managerID'];
    $mPassword = $_POST['mPassword'];
    $issueID = $_POST['issueID'];
    $issueName = $_POST['issueName'];
    $issueDes = $_POST['issueDes'];
    $issueResolvedDate = $_POST['issueResolvedDate'];

    // Validate managerID and password from the manager table
    $sql = "SELECT * FROM manager WHERE managerID = '$managerID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $manager = mysqli_fetch_assoc($result);

        if ($manager['mPassword'] == $mPassword) {
            // Check if the managerID exists in the headmanager table
            $checkHeadManagerSQL = "SELECT * FROM headmanager WHERE HmanagerID = '$managerID'";
            $checkHeadManagerResult = mysqli_query($conn, $checkHeadManagerSQL);

            if (mysqli_num_rows($checkHeadManagerResult) > 0) {
                // Escape special characters to avoid SQL errors
                $issueName = mysqli_real_escape_string($conn, $issueName);
                $issueDes = mysqli_real_escape_string($conn, $issueDes);
                $issueResolvedDate = mysqli_real_escape_string($conn, $issueResolvedDate);

                // Update the issue in the reportedissue table
                $sqlUpdate = "
                    UPDATE reportedissue 
                    SET 
                        issueName = '$issueName', 
                        issueDes = '$issueDes', 
                        issueResolvedDate = '$issueResolvedDate',
                        HmanagerID = '$managerID'
                    WHERE issueID = '$issueID'
                ";

                if (mysqli_query($conn, $sqlUpdate)) {
                    echo "<script>alert('Issue updated successfully!'); window.location.href = 'manageIssues.php';</script>";
                } else {
                    echo "<script>alert('Error updating issue: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Manager ID does not exist in the headmanager table.');</script>";
            }
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid manager ID or user not found.');</script>";
    }
}

// Fetch the issue details for pre-filling the form
if (!isset($_GET['issueID']) || empty($_GET['issueID'])) {
    echo "<script>alert('Issue ID is required.'); window.location.href = 'manageIssues.php';</script>";
    exit;
}

$issueID = $_GET['issueID'];
$sqlFetch = "SELECT * FROM reportedissue WHERE issueID = '$issueID'";
$issueResult = mysqli_query($conn, $sqlFetch);

if ($issueResult && mysqli_num_rows($issueResult) == 1) {
    $issue = mysqli_fetch_assoc($issueResult);
} else {
    echo "<script>alert('Issue not found.'); window.location.href = 'manageIssues.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Issue</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        .content {
            background-color: #f1f1f1;
            width: 600px;
            padding: 30px;
            border-radius: 10px;
            margin: auto;
            margin-left: 370px;
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
        /* Sidebar */
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

    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <main class="content">
            <header class="header">
                <h1>Edit Reported Issue</h1>
            </header>

            <div class="form-wrapper">
                <h2>Update Issue Details</h2>
                <form class="form" action="" method="POST">
                    <input type="hidden" name="issueID" value="<?php echo htmlspecialchars($issue['issueID']); ?>">

                    <div class="form-group">
                        <label for="managerID">Manager ID:</label>
                        <input type="text" id="managerID" name="managerID" placeholder="Enter your Manager ID" required>
                    </div>

                    <div class="form-group">
                        <label for="mPassword">Password:</label>
                        <input type="password" id="mPassword" name="mPassword" placeholder="Enter your password" required>
                    </div>

                    <div class="form-group">
                        <label for="issueName">Issue Name:</label>
                        <input type="text" id="issueName" name="issueName" value="<?php echo htmlspecialchars($issue['issueName']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="issueDes">Issue Description:</label>
                        <textarea id="issueDes" name="issueDes" required><?php echo htmlspecialchars($issue['issueDes']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="issueResolvedDate">Resolved Date:</label>
                        <input type="date" id="issueResolvedDate" name="issueResolvedDate" value="<?php echo htmlspecialchars($issue['issueResolvedDate']); ?>">
                    </div>

                    <button type="submit" class="sub-btn">Update Issue</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
