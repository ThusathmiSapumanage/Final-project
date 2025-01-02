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
        <title> Manage Food Supplies </title>
        <link rel="stylesheet" type="text/css" href="viewfood.css">
    </head>
    <body>
        <div class="container">
            <!-- Sidebar -->
            <?php include 'header.php'; ?>
            
            <!-- Main Content -->
            <main class="content">
                <header class="header">
                    <h1>Food Supply Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png" alt="Search">
                        <button>Search</button>
                    </div>
                </header>

                <!-- Food Section -->
                <section class="suppliers">
                    <h2>Food Items</h2>
                    <button class="adding"><a href="addFood.php">Add Food</a></button>
                    <div class="table1">
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
                    <a href="supplierM.html"><button class="back">Back</button></a>
                </section>
            </main>
        </div>
    </body>
</html>
