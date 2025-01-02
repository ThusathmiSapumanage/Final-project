<aside class="sidebar">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
    </div>
    <nav class="menu">
        <div class="dropdown">
            <a href="calendar.html" class="<?php echo basename($_SERVER['PHP_SELF']) === 'calendar.html' ? 'active' : ''; ?>">Events</a>
            <ul class="dropdown-menu">
                <li><a href="manageAddon.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageAddon.php' ? 'active2' : ''; ?>">Manage Add-Ons</a></li>
                <li><a href="viewHall.php" class="<?php echo basename($_SERVER['PHP_SELF']) === "viewHall.php" ? 'active2' : ''; ?>">Manage Halls</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <a href="supplierM.html" class="<?php echo basename($_SERVER['PHP_SELF']) === 'supplierM.html' ? 'active' : ''; ?>">Supplies</a>
            <ul class="dropdown-menu">
                <li><a href="manageFood.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageFood.php' ? 'active3' : ''; ?>">Manage Food</a></li>
                <li><a href="manageMerchandise.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageMerchandise.php' ? 'active3' : ''; ?>">Manage Merchandise</a></li>
                <li><a href="manageFoodSup.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageFoodSup.php' ? 'active3' : ''; ?>">Manage Food Supplier</a></li>
                <li><a href="manageMerchan.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageMerchan.php' ? 'active3' : ''; ?>">Manage Merchandise Supplier</a></li>
                <li><a href="manageInventory.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageInventory.php' ? 'active3' : ''; ?>">Manage Inventory</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <a href="financeM.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'financeM.php' ? 'active' : ''; ?>">Finance</a>
            <ul class="dropdown-menu">
                <li><a href="managePayments.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'managePayments.php' ? 'active2' : ''; ?>">View Payments</a></li>
                <li><a href="manageExpense.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageExpense.php' ? 'active2' : ''; ?>">View Expenses</a></li>
                <li><a href="expensereport.html" class="<?php echo basename($_SERVER['PHP_SELF']) === 'expensereport.html' ? 'active2' : ''; ?>">Expense & Income Chart and Report</a></li>
                <li><a href="expenseReports.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'expenseReports.php' ? 'active2' : ''; ?>">Expense Report</a></li>
                <li><a href="incomeReport.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'incomeReport.php' ? 'active2' : ''; ?>">Income Report</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <a href="staffM.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'staffM.php' ? 'active' : ''; ?>">Staff</a>
            <ul class="dropdown-menu">
                <li><a href="manageStaff.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageStaff.php' ? 'active2' : ''; ?>">Manage Staff</a></li>
                <li><a href="manageManager.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageManager.php' ? 'active2' : ''; ?>">Manage Managers</a></li>
                <li><a href="manageTasks.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageTasks.php' ? 'active2' : ''; ?>">Manage Tasks</a></li>
            </ul>
        </div>
        <a href="manageResource.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageResource.php' ? 'active' : ''; ?>">Resource</a>
        <a href="manageClient.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageClient.php' ? 'active' : ''; ?>">Customer</a>
        <a href="feedback.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'feedback.php' ? 'active' : ''; ?>">Feedback</a>
        <a href="manageIssues.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageIssues.php' ? 'active' : ''; ?>">Report Issues</a>
    </nav>
    <hr class="section-divider">
    <div class="settings"><img src="images/settings.png" alt="Settings">Settings</div>
</aside>
<main>
