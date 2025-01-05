<!DOCTYPE html>
<html>
    <head>
        <title>Staff Management</title>
        <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #ffffff;
            }

            .container {
                display: flex;
            }

            .custom-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 200px;
                background: #151515;
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
                margin-left: 190px;
                padding: 15px;
                background-color: #ffffff;
                width: 100%;
            }

            .header {
                margin-left: 30px;
                margin-bottom: 20px;
            }

            .search {
                display: flex;
                align-items: center;
                margin-top: 10px;
            }

            .search input {
                padding: 10px;
                margin-right: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                width: 250px;
            }

            .search button {
                padding: 10px 15px;
                background-color: #fdb827;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .search button:hover {
                background-color: #e5a800;
            }

            .actions {
                margin-left: 30px;
                margin-top: 20px;
            }

            .list-cata {
                display: flex;
                gap: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .supply-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 150px;
            }

            .supply-card .icon img {
                width: 80px;
                height: 80px;
                margin-bottom: 10px;
            }

            .supply-card p {
                margin: 10px 0;
                font-size: 14px;
                color: #333;
            }

            .supply-card button {
                margin-top: 10px;
                padding: 10px 15px;
                background-color: #fdb827;
                color: black;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .supply-card button:hover {
                background-color: #e5a800;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <!-- Sidebar -->
            <?php include 'header.php'; ?>

            <!-- Main Content -->
            <main class = "main-content">
                <header class="header">
                    <h1>Staff Management</h1>
                </header>

                <!-- Staff Actions Section -->
                <section class="actions">
                    <h2>Staff Actions</h2>
                    <div class="list-cata">
                        <div class="supply-card">
                            <div class="icon">
                                <img src="Images/teamwork.png">
                            </div>
                            <p>Staff Member Management</p>
                            <a href="manageStaff.php"><button>View</button></a>
                        </div>
                        <div class="supply-card">
                            <div class="icon">
                                <img src="Images/planning.png">
                            </div>
                            <p>Task Management</p>
                            <a href="manageTasks.php"><button>View</button></a>
                        </div>
                        <div class="supply-card">
                            <div class="icon">
                                <img src="Images/manager.png">
                            </div>
                            <p>Manage Managers</p>
                            <a href="manageManager.php"><button>View</button></a>
                        </div>
                        <div class="supply-card">
                            <div class="icon">
                                <img src="Images/hand.png">
                            </div>
                            <p>Manage Resource Allocation</p>
                            <a href="manageresourceallo.php"><button>View</button></a>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
