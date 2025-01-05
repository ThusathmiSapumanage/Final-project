<!DOCTYPE html>
<html>
<head>
    <title>Finance Management</title>
    <link rel="stylesheet" type="text/css" href="managecommonstyles.css">
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
        margin-left: 290px; /* Sidebar width */
        padding: 15px;
        background-color: #ffffff; /* White background for content */
        width: 100%;
    }

    .header {
        margin-left: 290px;
        color: white; /* Adds space between header and content */
    }

    .actions {
        margin: 20px 0; /* Adds space between sections */
    }

    .grid-container {
        margin-left: 190px;
        display: flex;
        flex-wrap: wrap; /* Allow cards to wrap on smaller screens */
        gap: 20px; /* Adds space between cards */
        justify-content: center; /* Center align cards */
    }

    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-align: center;
        width: 150px; /* Adjust width as needed */
        background-color: #fff; /* Card background */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .card img {
        width: 80px;
        height: 80px;
        margin-bottom: 10px;
    }

    .card p {
        margin: 10px 0;
        font-size: 14px;
        color: #333;
    }

    .card button {
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #fdb827; /* Button background */
        color: black;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .card button:hover {
        background-color: #e5a800; /* Darker yellow on hover */
    }
</style>

</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Finance Management</h1>
            </header>

            <!-- Finance Actions Section -->
            <section class="actions">
                <h2>Finance Actions</h2>
                <div class="grid-container">
                    <div class="card">
                        <div class="icon">
                            <img src="Images/cuss.png" alt="Client Payments Icon">
                        </div>
                        <p>View payments made by clients</p>
                        <a href="managePayments.php"><button class="view-btn">View</button></a>
                    </div>
                    <div class="card">
                        <div class="icon">
                            <img src="Images/expenses.png" alt="Expenses Icon">
                        </div>
                        <p>View expenses made by gapHQ</p>
                        <a href="manageExpense.php"><button class="view-btn">View</button></a>
                    </div>
                    <div class="card">
                        <div class="icon">
                            <img src="Images/bar-chart.png" alt="Chart Icon">
                        </div>
                        <p>View reports</p>
                        <a href="manageReports.php"><button class="view-btn">View</button></a>
                    </div>                    
                    <div class="card">
                        <div class="icon">
                            <img src="Images/records.png" alt="Records Icon">
                        </div>
                        <p>Create invoices</p>
                        <a href="invoicegen.html"><button class="create-btn">Create</button></a>
                    </div>
                    <div class="card">
                        <div class="icon">
                            <img src="Images/money.png" alt="Records Icon">
                        </div>
                        <p>Track payments</p>
                        <a href="404_admin.html"><button class="create-btn">Track</button></a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
