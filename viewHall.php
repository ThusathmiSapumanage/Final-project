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
    <title>View Halls</title>
    <link rel="stylesheet" href="viewmerchan.css">
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="content">
        <header class="header">
            <h1>Halls</h1>
            <button class="adding"><a href="addHall.php">Add Hall</a></button>
        </header>

        <section class="table1">
            <table class="table centered">
                <thead>
                    <tr>
                        <th>Hall ID</th>
                        <th>Name</th>
                        <th>Capacity</th>
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
                            echo "<td>" . htmlspecialchars($row['hallLocation']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
                            echo "<td class='actions'>
                                    <a href='updateHall.php?id={$row['hallID']}' class='btn update-btn'>Update</a>
                                    <form action='' method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_id' value='{$row['hallID']}'>
                                        <button type='submit' class='btn delete-btn'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
