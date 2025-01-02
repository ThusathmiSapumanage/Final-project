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
    <link rel="stylesheet" type="text/css" href="viewfood.css">
    <style>
        .adding {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .adding a {
            color: white;
            text-decoration: none;
        }

        .adding:hover {
            background-color: #218838;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .actions .btn {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .update-btn {
            background-color: #ffc107;
            color: white;
        }

        .update-btn:hover {
            background-color: #e0a800;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>


        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Resource Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="images/search-interface-symbol.png" alt="Search">
                    <button>Search</button>
                </div>
            </header>

            <!-- Resources Section -->
            <section class="resources">
                <h2>Resources</h2>
                <button class="adding"><a href="addResource.php">Add Resource</a></button>
                <div class="table1">
                    <table class="table centered">
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
