<?php
include "config.php";

// Retrieve the staffID from the query string
$staffID = isset($_GET['staffID']) ? $_GET['staffID'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $designTools = mysqli_real_escape_string($conn, $_POST['designTools']);
    $experience = intval($_POST['experience']);

    // Insert into `graphicdesigner` table
    $sql = "INSERT INTO graphicdesigner (GstaffID, designTools, experience) 
            VALUES ('$staffID', '$designTools', '$experience')";

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
    <title>Add Graphic Designer</title>
    <link rel="stylesheet" type="text/css" href="addcommon.css">
    <style>
        .main-content
        {
            background-color: #ffffff;
        }
        .back-btn
        {
            background-color: #fdb827;
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .container
        {
            margin-left: 120px;
        }
        .actions
        {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <main class="main-content">
            <header class="header">
                <h1>Add Graphic Designer</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Graphic Designer Details</h2>
                    <form class="form" action="addGraphicDesigner.php?staffID=<?php echo htmlspecialchars($staffID); ?>" method="post">
                        <label for="designTools">Design Tools:</label>
                        <input type="text" id="designTools" name="designTools" placeholder="Enter design tools (e.g., Photoshop, Illustrator)" required>

                        <label for="experience">Experience (years):</label>
                        <input type="number" id="experience" name="experience" placeholder="Enter experience in years" required>

                        <button class="sub-btn" type="submit" name="submit">Add Graphic Designer</button>
                    </form>
                    <div class="back-link">
                        <br><br>
                        <a href="addStaff.php" class="back-btn">Back to Add Staff</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
