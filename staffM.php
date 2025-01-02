<!DOCTYPE html>
<html>
    <head>
        <title> Staff Management </title>
        <link rel="stylesheet" type="text/css" href="supplierM.css">
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class = "content">
                <header class="header">
                    <h1>Staff Management</h1>
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <img src="Images/search-interface-symbol.png">
                        <button>Search</button>
                    </div>
            	</header>

            <!-- Suppliers Section -->
            <section class = "actions">
                <h2>Staff Actions</h2>
                <div class = "list-cata">
                    <div class ="supply-card">
                        <div class = "icon">
                            <img src = "Images/teamwork.png">
                        </div>
                        <p>Staff Member Management</p>
                        <a href="manageStaff.php"><button>View</button></a>
                    </div>
                    <div class ="supply-card">
                        <div class = "icon">
                            <img src = "Images/planning.png">
                        </div>
                        <p>Task Management</p>
                        <a href = "manageTasks.php"><button>View</button></a>
                    </div>
                </div>
            </section>
        </main>
    </div>
    </body>
</html>
