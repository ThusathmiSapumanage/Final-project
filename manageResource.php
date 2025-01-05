<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id']; // Get the ID as a string

    // Check if ID is not empty
    if (!empty($id)) {
        $sql = "DELETE FROM resources WHERE resourceID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $id); // Bind the ID as a string

            if ($stmt->execute()) {
                echo "<script>alert('Resource deleted successfully. Redirecting to the view page...');</script>";
                echo "<script>window.location.href = 'manageResource.php';</script>";
            } else {
                echo "<script>alert('Error deleting resource: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid resource ID.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Resources</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
        }

        .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        }

        .table-container {
        background-color: white;
        width: 100%;	
        height: 100%;
        }

        .custom-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 200px; /* Sidebar width */
        background: #151515; /* Sidebar background color */
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
        margin-left: 200px; /* Sidebar width */
        padding: 20px;
        background-color: #ffffff; /* White background for content */
        width: 100%;
        }
        .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: #fdb827;
        color: black;
        text-decoration: none;
        border-radius: 5px;
        }
        .add-btn a
        {
            text-decoration: none;
            color: black;
        }

    </style>
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Resource Management</h1>
            </header>

            <!-- Resources Section -->
            <section class="section">
                <h2>Resources</h2>
                <button class="btn add-btn"><a href="addResource.php">Add Resource</a></button>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Resource ID</th>
                                <th>Resource Name</th>
                                <th>Allocation Status</th>
                                <th>Description</th>
                                <th>Manager ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM resources";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['resourceID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['resourceName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['resourceAllocationStatus']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['resourceDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                    echo "<td class='actions'>
                                        <a href='updateResource.php?id=" . htmlspecialchars($row['resourceID']) . "' class='btn update-btn'>Update</a>
                                        <form action='' method='POST' style='display: inline;'>
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['resourceID']) . "'>
                                            <button type='submit' class='btn delete-btn'>Delete</button>
                                        </form>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
