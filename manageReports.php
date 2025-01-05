<!DOCTYPE html>
<html>
<head>
    <title>Report Management</title>
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
            margin-left: 220px;
            padding: 20px;
            background-color: #ffffff;
            width: calc(100% - 220px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search input {
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px;
        }

        .search button {
            padding: 8px 12px;
            border: none;
            background: #fdb827;
            color: black;
            border-radius: 5px;
            cursor: pointer;
        }

        .search button:hover {
            background-color: #e6a917;
        }

        .actions {
            margin-top: 20px;
        }

        .list-cata {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .supply-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            width: 200px;
            transition: transform 0.3s;
        }

        .supply-card:hover {
            transform: scale(1.05);
        }

        .supply-card .icon img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .supply-card p {
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .supply-card button {
            padding: 10px 15px;
            background-color: #fdb827;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .supply-card button:hover {
            background-color: #e6a917;
        }

        .back-btn {
            height: 20px;
            display: inline-block;
            margin-top: 250px;
            margin-left: 432px;
            padding: 10px 20px;
            background: #fdb827;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background 0.3s, transform 0.2s;
        }

        .back-btn:hover {
            background-color: #e6a917;
            transform: scale(1.05);
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
                <h1>Report Management</h1>
            </header>

            <!-- Finance Actions Section -->
            <section class="actions">
                <h2>Finance Actions</h2>
                <div class="list-cata">
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/cuss.png">
                        </div>
                        <p>View staff task report</p>
                        <a href="tasksReport.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/expenses.png">
                        </div>
                        <p>View client payment report</p>
                        <a href="clientPaymentReport.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/bar-chart.png">
                        </div>
                        <p>View merchandise and inventory</p>
                        <a href="merchReport.php"><button>View</button></a>
                    </div>                    
                    <div class="supply-card">
                        <div class="icon">
                            <img src="images/records.png">
                        </div>
                        <p>View events report</p>
                        <a href="eventsReport.php"><button>View</button></a>
                    </div>
                    <a href="financeM.php" class="back-btn">Back</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
