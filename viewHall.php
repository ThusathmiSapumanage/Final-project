<?php
include 'config.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $deleteSql = "DELETE FROM hall WHERE hallID = $id";

    if (mysqli_query($conn, $deleteSql)) {
        echo "<script>alert('Hall deleted successfully!'); window.location.href = 'viewHall.php';</script>";
    } else {
        echo "Error deleting hall: " . mysqli_error($conn);
    }
}

// Fetch all halls
$sql = "SELECT * FROM hall";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Halls</title>
    <link rel="stylesheet" href="managecommonstyles.css">
    <style>
        /* Sidebar */
.custom-sidebar {
    width: 250px; /* Adjust width as needed */
    background: #151515;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0; /* Move the sidebar to the left corner */
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 1000; /* Ensure the sidebar stays above other elements */
}

/* Main Content */
.main-content {
    margin-left: 250px; /* Adjusted for sidebar width */
    padding: 20px;
    background: white;
    color: black;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    min-height: 100vh;
    overflow-y: auto;
}
</style>
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-inner">
            <header class="content-header">
                <h1>Manage Halls</h1>
                <a href="addHall.php" class="add-btn">Add Hall</a>
            </header>

            <section class="table-section">
                <table class="table centered">
                    <thead>
                        <tr>
                            <th>Hall ID</th>
                            <th>Name</th>
                            <th>Capacity</th>
                            <th>Image</th>
                            <th>Location</th>
                            <th>Manager ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['hallID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['hallName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['hallCapacity']) . "</td>";
                                echo "<td><img src='uploads/" . htmlspecialchars($row['hallLayout']) . "' alt='Hall Layout' class='table-img'></td>";
                                echo "<td>" . htmlspecialchars($row['hallLocation']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
                                echo "<td class='actions'>
                                        <a href='updateHall.php?id={$row['hallID']}' class='update-btn'>Update</a>
                                        <form action='' method='POST' style='display:inline;'>
                                            <input type='hidden' name='delete_id' value='{$row['hallID']}'>
                                            <button type='submit' class='delete-btn'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</div>
</body>
</html>
