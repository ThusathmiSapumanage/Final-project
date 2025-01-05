<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Sanitize the `delete_id`
    $id = intval($_POST['delete_id']);

    // SQL to delete a food item
    $sql = "DELETE FROM food WHERE foodID = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Food item deleted successfully. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageFood.php';</script>";
    } else {
        echo "<script>alert('Error deleting food item: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Food Supplies</title>
        <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
        <style>
        body {
        margin: 0;
        font-family: Arial, sans-serif;/* White background */
        }

        .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        }

        .container {
        background-color: white;
        padding: 30px;
        display: flex;
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
        margin-left: 220px; /* Sidebar width */
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
    </style>
    </head>
    <body>
        <div class="container">
            <!-- Sidebar -->
            <?php include 'header.php'; ?>
            
            <!-- Main Content -->
            <main class="main-content">
                <header class="header">
                    <h1 style = 'color: white;'>Food Supply Management</h1>
                </header>

                <!-- Food Section -->
                <section class="table-container">
                    <h2>Food Items</h2>
                    <a href="addFood.php" class="add-btn">Add Food</a>
                    <div class="table-responsive">
                        <table class="table centered">
                            <thead>
                                <tr>
                                    <th>Food Name</th>
                                    <th>Food Price</th>
                                    <th>Minimum Order</th>
                                    <th>Ingredients</th>
                                    <th>More Info</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch food data from the `food` table
                                $sql = "SELECT * FROM food";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['foodName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['foodPrice']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['minFoodOrder']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['ingredients']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['moreInfo']) . "</td>";
                                        echo "<td class='actions'>
                                            <a href='updateFood.php?id=" . $row['foodID'] . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_id' value='" . $row['foodID'] . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                          </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No food items found</td></tr>";
                                }

                                // Close the connection
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="supplierM.php" class="back-btn">Back</a>
                </section>
            </main>
        </div>
    </body>
</html>
