<!DOCTYPE html>
<html>
    <head>
        <title>View Reported Issues</title>
        <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
        <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4; /* Light gray background */
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

    .container {
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        min-height: 100vh; /* Full screen height */
    }

    .main-content {
        background-color: #ffffff; /* White background */
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        width: 80%; /* Adjust width as needed */
        max-width: 1200px; /* Maximum width for larger screens */
    }

    .header h1 {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .section h2 {
        font-size: 20px;
        margin-bottom: 20px;
        color: #555;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }

    .table th,
    .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 14px;
    }

    .table th {
        background-color: #fdb827; /* Yellow background for headers */
        color: #000;
        font-weight: bold;
    }

    .table td {
        color: #333;
    }

    .add-btn {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .add-btn a {
        color: white;
        text-decoration: none;
    }

    .add-btn:hover {
        background-color: #218838;
    }

    .edit-link {
        color: #007bff;
        text-decoration: none;
    }

</style>
<div class="container">
    <?php include 'header.php'; ?>

    <div class="main-content">
        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Reported Issue Management</h1>
            </header>

            <!-- Reported Issues Section -->
            <section class="section">
                <h2>Reported Issues</h2>
                <button class="add-btn"><a href="addIssue.php">Add Issue</a></button>
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Issue ID</th>
                                <th>Issue Name</th>
                                <th>Posted Date</th>
                                <th>Resolved Date</th>
                                <th>Description</th>
                                <th>Head Manager ID</th>
                                <th>Photographer Staff ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'config.php';

                            // Fetch data from the `reportedissue` table
                            $sql = "SELECT * FROM reportedissue";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['issueID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['issueName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['issuePostedDate']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['issueResolvedDate'] ?: 'Not Resolved') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['issueDes']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['PstaffID']) . "</td>";
                                    echo "<td>
                                         <a class='edit-link' href='editIssue.php?issueID=" . $row['issueID'] . "'>Update</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No records found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>
