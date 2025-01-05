<?php

include "config.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Resource Allocations</title>
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
                <h1>Resource Allocations</h1>
            </header>

            <!-- Resources Section -->
            <section class="section">
                <h2>Resources</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Resource ID</th>
                                <th>Photographer ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM photographerresources";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['resourceID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['PstaffID']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No records found</td></tr>";
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
