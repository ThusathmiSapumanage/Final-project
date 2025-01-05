<?php

include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM merchandise WHERE merchandiseID = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Merchandise deleted successfully! Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageMerchandise.php';</script>";
    } else {
        echo "<script>alert('Error deleting merchandise: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Merchandise Supplies</title>
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
        flex-wrap: wrap; /* Ensure buttons wrap to fit in narrow spaces */
        }

        .container {
        background-color: white;
        padding: 30px;
        margin-left: 230px;
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
        
    .actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px; /* Space between buttons */
        flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
    }

    .actions .btn {
        display: inline-block;
        padding: 5px 10px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        max-width: 90px; /* Limit button width to avoid overflow */
        box-sizing: border-box;
    }

    .actions .update-btn {
        background-color: #ffc107; /* Yellow */
        color: black;
    }

    .actions .delete-btn {
        background-color: #dc3545; /* Red */
        color: white;
    }

    .actions .btn:hover {
        opacity: 0.9;
    }

    @media screen and (max-width: 768px) {
        .actions {
            flex-direction: column; /* Stack buttons vertically on small screens */
        }

        .actions .btn {
            width: 100%; /* Full width buttons for small screens */
            margin-bottom: 5px; /* Add spacing between stacked buttons */
        }
    }
    </style>

</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Merchandise Supply Management</h1>
            </header>

            <!-- Merchandise Section -->
            <section class="suppliers">
                <h2>Merchandise</h2>
                <a href="addMerchandise.php" class="add-btn">Add Merchandise</a>
                <div class="table-container">
                    <table class="table centered">
                        <thead>
                            <tr>
                                <th>Merchandise Name</th>
                                <th>Product Image</th>
                                <th>Price per Unit</th>
                                <th>Quantity in Stock</th>
                                <th>On Sale</th>
                                <th>Product Category</th>
                                <th>Description</th>
                                <th>Supplier ID</th>
                                <th>Manager ID</th>
                                <th>Inventory ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM merchandise"; 
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['productName']) . "</td>";

                                    // Display image
                                    $imageData = base64_encode($row['productImage']);
                                    echo "<td><img src='data:image/jpeg;base64," . $imageData . "' alt='Product Image' class='product-image'></td>";

                                    echo "<td>" . htmlspecialchars($row['pricePerUnit']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantityInStock']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['isOnSale']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['productCategory']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['productDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['MsupplierID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['EmanagerID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['inventoryID']) . "</td>";
                                    echo "<td class='actions'>
                                            <a href='updateMerchandise.php?id=" . $row['merchandiseID'] . "' class='btn update-btn'>Update</a>
                                            <form action='' method='POST' style='display: inline;'>
                                                <input type='hidden' name='delete_id' value='" . $row['merchandiseID'] . "'>
                                                <button type='submit' class='btn delete-btn'>Delete</button>
                                            </form>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'>No records found</td></tr>";
                            }
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
