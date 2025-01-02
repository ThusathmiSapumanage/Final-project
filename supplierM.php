<!DOCTYPE html>
<html>
    <head>
        <title> Supplier & Supply Management </title>
        <link rel="stylesheet" type="text/css" href="supplierM.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Supplier & Supply Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>

            <!-- Suppliers Section -->
            <section class = "suppliers">
                <h2>Suppliers</h2>
                <div class = "list">
                    <a href="manageFoodSup.php">
                        <div class="sup-card">
                            <img src="Images/food-security.png">
                            <span>Food suppliers</span>
                        </div>
                    </a>
                    <a href="manageMerchan.php">
                        <div class="sup-card">
                            <img src="Images/clerk.png">
                            <span>Merchandise suppliers</span>
                        </div>
                    </a>
                    <a href="manageInventory.php">
                        <div class="sup-card">
                            <img src="Images/inventory.png">
                            <span>Inventory list</span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- Supplies Sectopn -->
            <section class = "supplies">
                <h2>Supplies</h2>
                <div class = "list-cata">
                    <div class ="supply-card">
                        <div class = "icon">
                            <img src = "Images/fast-food.png">
                        </div>
                        <p>Food & Beverages</p>
                        <a href="manageFood.php"><button>View</button></a>
                    </div>
                    <div class ="supply-card">
                        <div class = "icon">
                            <img src = "Images/merchandise.png">
                        </div>
                        <p>Merchandise</p>
                        <a href = "manageMerchandise.php"><button>View</button></a>
                    </div>
                </div>
            </section>
            </main>
        </div>
    </body>
</html>