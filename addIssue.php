<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    $reportName = $_POST['reportName'];
    $reportType = $_POST['reportType'];
    $reportDes = $_POST['reportDes'];

    $sql = "INSERT INTO eventreport (reportName, reportType, reportDes) VALUES ('$reportName', '$reportType', '$reportDes')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manageIssues.php");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Issue</title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Reported Issue Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Add Issue</h2>
                        <form class = "form" action="addIssue.php" method="post">

                            <label for="reportName">Report Name</label>
                            <input type="text" id="reportName" name="reportName" required>

                            <label for="reportType">Report Type (Please select a type)</label>
                            <select id="reportType" name="reportType" required>
                                <option value="1">Technical</option>
                                <option value="2">Non-Technical</option>
                            </select></br>

                            <label for="reportDes">Report Description</label>
                            <input type="text" id="reportDes" name="reportDes" required>

                            <button class = "sub-btn" type="submit" name="submit">Add Issue</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>