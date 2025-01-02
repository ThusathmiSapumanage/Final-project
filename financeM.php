<!DOCTYPE html>
<html>
<head>
    <title>Finance Management</title>
    <link rel="stylesheet" type="text/css" href="financeM.css">
</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <?php include 'header.php'; ?>

        <!-- Main Content -->
        <main class="content">
            <header class="header">
                <h1>Finance Management</h1>
                <div class="search">
                    <input type="text" placeholder="Search">
                    <img src="Images/search-interface-symbol.png">
                    <button>Search</button>
                </div>
            </header>

            <!-- Finance Actions Section -->
            <section class="actions">
                <h2>Finance Actions</h2>
                <div class="list-cata">
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/cuss.png">
                        </div>
                        <p>View payments made by clients</p>
                        <a href="managePayments.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/expenses.png">
                        </div>
                        <p>View expenses made by gapHQ</p>
                        <a href="manageExpense.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/bar-chart.png">
                        </div>
                        <p>View expense & income chart and report</p>
                        <a href="expensereport.html"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/wallet.png">
                        </div>
                        <p>View expense report</p>
                        <a href="expenseReports.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="Images/capital.png">
                        </div>
                        <p>View income report</p>
                        <a href="incomeReport.php"><button>View</button></a>
                    </div>
                    <div class="supply-card">
                        <div class="icon">
                            <img src="images/records.png">
                        </div>
                        <p>Create financial records</p>
                        <a href="createRecords.html"><button>Create</button></a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
