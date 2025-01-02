<?php

include "config.php";


$iID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $iID = intval($_POST['iID']);
    $des = mysqli_real_escape_string($conn, $_POST['des']);

    // Update query
    $sql = "UPDATE inventory
            SET inventoryDes = '$des' 
            WHERE inventoryID = $iID";

    // Execute query and redirect
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update successful. Redirecting to the view page...');</script>";
        echo "<script>window.location.href = 'manageInventory.php';</script>";
        exit;
    } else {
        echo "Error updating supplier: " . mysqli_error($conn);
    }
}


$des = "";

if ($iID > 0) {
    
    $sql2 = "SELECT * FROM inventory WHERE inventoryID = $iID";
    $result = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $des = $row['inventoryDes'];
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Inventory </title>
        <link rel="stylesheet" type="text/css" href="addFoodsup.css">
    </head>
    <body>
        <div class="container">

        <?php include 'header.php'; ?>

              <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Inventory Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>
                <div class="content-inner">
                    <div class="content-box">
                        <h2>Update Inventories</h2>
                        <form class="form" action="updateInventory.php" method="post">

                        <label for="id">Inventory ID:</label>
                        <input type="text" name="iID" value="<?php echo htmlspecialchars($iID); ?>" readonly>

                        <label for="name">Description:</label>
                        <input type="text" id="des" name="des" value="<?php echo htmlspecialchars($des); ?>" required>

                        <button class="sub-btn" type="submit" name="submit">Update Inventory</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>