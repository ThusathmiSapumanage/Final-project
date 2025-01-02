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
    <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    <style>
                    .sub-btn {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;
                    }

                    .sub-btn:hover {
                        background-color: #45a049;
                    }

                    .back-btn {
                        background-color: #f44336;
                        color: white;
                        padding: 10px 20px;
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
        <main class="content">
            <header class="header">
                <h1>Add Graphic Designer</h1>
            </header>
            <div class="content-inner">
                <div class="content-box">
                    <h2>Graphic Designer Details</h2>
                    <form class="form" action="addGraphicDesigner.php?staffID=<?php echo htmlspecialchars($staffID); ?>" method="post">
                        <label for="designTools">Design Tools:</label>
                        <input type="text" id="designTools" name="designTools" required>

                        <label for="experience">Experience (years):</label>
                        <input type="number" id="experience" name="experience" required>

                        <button class="sub-btn" type="submit" name="submit">Add Graphic Designer</button>
                    </form>
                    <a href="addStaff.php"><button class="back-btn">Back</button></a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
