<!DOCTYPE html>
<html>
<head>
    <title>Supplier & Supply Management</title>
    <link rel="stylesheet" href="managecommonstyles.css">
    <link rel = "stylesheet" type = "text/css" href = "supplierM.css">
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff; /* White background */
    }

    .container {
        display: flex;
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
    
    .suppliers, .supplies {
        margin: 20px 0; /* Adds space between sections */
    }

    .list, .list-cata {
        display: flex;
        flex-direction: row; /* Arrange the cards horizontally */
        gap: 20px; /* Adds space between the cards */
        justify-content: center; /* Center align cards */
    }

    .list a, .list-cata a {
        text-decoration: none;
        color: #000;
    }

    .sup-card, .supply-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-align: center;
        width: 150px; /* Adjust width as needed */
    }

    .sup-card img, .supply-card img {
        width: 80px;
        height: 80px;
        margin-bottom: 10px;
    }

    .sup-card span, .supply-card button {
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .sup-card span:hover, .supply-card button:hover {
        background-color: #444;
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
                <h1>Supplier & Supply Management</h1>
            </header>

            <!-- Suppliers Section -->
            <section class="suppliers">
                <h2>Suppliers</h2>
                <div class="list">
                    <a href="manageFoodSup.php">
                        <div class="sup-card">
                            <img src="Images/food-security.png" alt="Food Suppliers Icon">
                            <span>Food Suppliers</span>
                        </div>
                    </a>
                    <a href="manageMerchan.php">
                        <div class="sup-card">
                            <img src="Images/clerk.png" alt="Merchandise Suppliers Icon">
                            <span>Merchandise Suppliers</span>
                        </div>
                    </a>
                    <a href="manageInventory.php">
                        <div class="sup-card">
                            <img src="Images/inventory.png" alt="Inventory List Icon">
                            <span>Inventory List</span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- Supplies Section -->
            <section class="supplies">
                <h2>Supplies</h2>
                <div class="list-cata">
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/fast-food.png" alt="Food & Beverages Icon">
                        </div>
                        <p>Food & Beverages</p>
                        <a href="manageFood.php"><button class="view-btn">View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/merchandise.png" alt="Merchandise Icon">
                        </div>
                        <p>Merchandise</p>
                        <a href="manageMerchandise.php"><button class="view-btn">View</button></a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
