<?php

include "config.php";

// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    // Delete from specific tables first to satisfy foreign key constraints
    $sql_photographer = "DELETE FROM photographer WHERE PstaffID = '$id'";
    $sql_graphicdesigner = "DELETE FROM graphicdesigner WHERE GstaffID = '$id'";
    
    // Execute deletions from specific tables
    mysqli_query($conn, $sql_photographer);
    mysqli_query($conn, $sql_graphicdesigner);

    // Now delete from `hiringstaff` table
    $sql_hiringstaff = "DELETE FROM hiringstaff WHERE staffID = '$id'";
    if (mysqli_query($conn, $sql_hiringstaff)) {
        echo "<script>alert('Staff profile deleted successfully! Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageStaff.php';</script>";
    } else {
        echo "Error deleting staff: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Staff</title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
        <style>
            .table-section {
                margin-bottom: 30px; /* Adds space between the tables */
            }
            .hidden-password {
                font-family: monospace;
                letter-spacing: 0.3em;
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
                    <h1>Staff Management</h1>
                </header>

                <!-- Photographers Section -->
                <section class="table-section">
                    <h2>Photographers</h2>
                    <a href="addStaff.php" class="adding">Add Staff</a>
                    <style>
                        .adding {
                            display: inline-block;
                            margin-bottom: 10px;
                            padding: 10px 20px;
                            background-color: #4CAF50;
                            color: white;
                            text-decoration: none;
                            border-radius: 5px;
                            position: absolute;
                            right: -190px;
                            top: 90px;
                        }

                        .adding:hover {
                            background-color: #45a049;
                        }

                        .table1 {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        .table1 th, .table1 td {
                            border: 1px solid #ddd;
                            padding: 8px;
                        }

                        .table1 th {
                            background-color: #f2f2f2;
                            text-align: center;
                        }

                        .table1 td {
                            text-align: center;
                        }

                        .actions .btn {
                            padding: 5px 10px;
                            margin: 2px;
                            text-decoration: none;
                            border-radius: 3px;
                            color: white;
                        }

                        .update-btn {
                            background-color: #4CAF50;
                        }

                        .update-btn:hover {
                            background-color: #45a049;
                        }

                        .delete-btn {
                            background-color: #f44336;
                        }

                        .delete-btn:hover {
                            background-color: #da190b;
                        }
                    </style>
                    <div class="table1">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Availability</th>
                                    <th>Hourly Rate</th>
                                    <th>Password</th>
                                    <th>Manager ID</th>
                                    <th>Event Coverage Count</th>
                                    <th>Specialization</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT h.*, p.eventCoverageCount, p.specialization 
                                        FROM hiringstaff h 
                                        JOIN photographer p ON h.staffID = p.PstaffID";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffType']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffAvailability']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['hourlyRate']) . "</td>";
                                        echo "<td class='hidden-password'>******</td>";
                                        echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['eventCoverageCount']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                                        echo "<td class='actions'>
                                                <a href='updatePhotog.php?id=" . htmlspecialchars($row['staffID']) . "' class='btn update-btn'>Update</a>
                                                <form action='' method='POST' style='display: inline;'>
                                                    <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['staffID']) . "'>
                                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Graphic Designers Section -->
                <section class="table-section">
                    <h2>Graphic Designers</h2>
                    <div class="table1">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Availability</th>
                                    <th>Hourly Rate</th>
                                    <th>Password</th>
                                    <th>Manager ID</th>
                                    <th>Design Tools</th>
                                    <th>Experience</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT h.*, g.designTools, g.experience 
                                        FROM hiringstaff h 
                                        JOIN graphicdesigner g ON h.staffID = g.GstaffID";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffType']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['staffAvailability']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['hourlyRate']) . "</td>";
                                        echo "<td class='hidden-password'>******</td>";
                                        echo "<td>" . htmlspecialchars($row['HmanagerID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['designTools']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['experience']) . "</td>";
                                        echo "<td class='actions'>
                                                <a href='updateGD.php?id=" . htmlspecialchars($row['staffID']) . "' class='btn update-btn'>Update</a>
                                                <form action='' method='POST' style='display: inline;'>
                                                    <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['staffID']) . "'>
                                                    <button type='submit' class='btn delete-btn'>Delete</button>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
