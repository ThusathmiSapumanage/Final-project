<!DOCTYPE html>
<html>
    <head>
        <title>Feedback Management</title>
        <link rel="stylesheet" type="text/css" href="feedback.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="logo">
                    <img src="images/logo.png" alt="Logo">
                </div>
                <nav class="menu">
                    <a href="calendar.html">Events</a>
                    <div class="dropdown">
                        <a href="supplierM.html">Supplies</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageFood.php" class="active3">Manage Food</a></li>
                            <li><a href="manageMerchandise.php" class="active3">Manage Merchandise</a></li>
                            <li><a href="manageFoodSup.php" class="active3">Manage Food Supplier</a></li>
                            <li><a href="manageMerchan.php" class="active3">Manage Merchandise Supplier</a></li>
                        </ul>
                    </div>
                    <a href="#">Finance</a>
                    <div class="dropdown">
                        <a href="staffM.html">Staff</a>
                        <ul class="dropdown-menu">
                            <li><a href="manageStaff.php" class="active3">Manage Staff</a></li>
                            <li><a href="manageTasks.php" class="active3">Manage Tasks</a></li>
                        </ul>
                    </div>
                    <a href="manageResource.php">Resource</a>
                    <a href="#">Client</a>
                    <a href="feedback.php" class="active">Feedback</a>
                </nav>
                <hr class="section-divider">
                <div class="settings"><img src="Images/settings.png">Settings</div>
            </aside>

            <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Feedback Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
                </header>

                <!-- Feedback Section -->
                <section class="feedback">
                    <h2>Latest Reviews</h2>
                    <div class="list">
                    <?php

                        include "config.php";

                        $sql = "SELECT * FROM feedback ORDER BY date DESC";
                        $result = mysqli_query($conn, $sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="feedback-card">';
                                echo '<div class="card-header">';
                                echo '<span class="stars">' . str_repeat('★', $row['rating']) . '</span>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                                echo '<p>' . htmlspecialchars($row['feedback']) . '</p>';
                                echo '</div>';
                                echo '<div class="card-footer">';
                                echo '<div class="review-info">';
                                echo '<img src="Images/user.png" alt="Reviewer pic">';
                                echo '<div>';
                                echo '<p>' . htmlspecialchars($row['name']) . '</p>';
                                echo '<span>' . htmlspecialchars($row['date']) . '</span>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="buttons">';
                                echo '<form action="delete_feedback.php" method="POST" style="display: inline-block;">';
                                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                                echo '<button type="submit" name="submit" class="del">Delete</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        else 
                        {
                            echo '<p>No feedback available.</p>';
                        }

                        mysqli_close($conn);

                    ?>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
