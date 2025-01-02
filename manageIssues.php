<!DOCTYPE html>
<html>
    <head>
        <title> View reported issues </title>
        <link rel="stylesheet" type="text/css" href="viewmerchan.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Reported Issue Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>

                <!-- Suppliers Section -->
                <section class = "suppliers">
                    <h2>Reported Issues</h2>
                    <button class = "adding"><a href="addIssue.php">Add Issue</a></button>
                    <div class="table1">
            <table class="table centered">
                <thead>
                <tr>
                        <th>Report ID</th>
                        <th>Name</th>
                        <th>Report date</th>
                        <th>Report type</th>
                        <th>Report description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    include 'config.php';

                    $sql = "SELECT * FROM eventreport";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['reportID'] . "</td>";
                            echo "<td>" . $row['reportName'] . "</td>";
                            echo "<td>" . $row['reportDate'] . "</td>";
                            echo "<td>" . $row['reportType'] . "</td>";
                            echo "<td>" . $row['reportDes'] . "</td>";
                            echo "</tr>";
                        }
                    } 
                    else 
                    {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
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