<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if delete request is sent
    if (isset($_POST['delete_resourceID']) && isset($_POST['delete_PstaffID'])) {
        $resourceID = mysqli_real_escape_string($conn, $_POST['delete_resourceID']);
        $PstaffID = mysqli_real_escape_string($conn, $_POST['delete_PstaffID']);

        // Delete query
        $sql = "DELETE FROM resource_allocation WHERE resourceID = '$resourceID' AND PstaffID = '$PstaffID'";

        // Execute query and check for success
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Resource allocation deleted successfully!');</script>";
            echo "<script>window.location.href = 'manageResources.php';</script>";
        } else {
            echo "<script>alert('Error deleting resource allocation: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Resource Allocation</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
    <style>
        .actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .container {
            background-color: white;
            padding: 30px;
            margin-left: 300px;
            display: flex;
        }
        .table-container {
            background-color: white;
            width: 100%;
            height: 100%;
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

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Resource Allocation Management</h1>
            </header>

            <!-- Resource Allocation Section -->
            <section class="resource-allocation">
                <h2>Allocate Resources</h2>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Resource ID</th>
                                <th>Photographer Staff ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'config.php';

                            $sql = "SELECT * FROM photographerresources";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['resourceID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['PstaffID']) . "</td>";
                                    echo "<td class='actions'>
                                            <a href='updateResourceallo.php?resourceID=" . htmlspecialchars($row['resourceID']) . "&PstaffID=" . htmlspecialchars($row['PstaffID']) . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_resourceID' value='" . htmlspecialchars($row['resourceID']) . "'>
                                                <input type='hidden' name='delete_PstaffID' value='" . htmlspecialchars($row['PstaffID']) . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No records found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="staffM.php" class="back-btn">Back</a>
            </section>
        </main>
    </div>
</body>
</html>
