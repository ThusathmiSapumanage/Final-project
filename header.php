<?php
// Start a session if not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the role from the session or set it as empty
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<aside class="custom-sidebar">
    <div class="logo">
        <a href="dash.php">
            <img src="images/logo.png" alt="Logo">
        </a>
    </div>
    <nav class="menu">
        <!-- Events Section -->
        <?php if ($role === 'Event Manager' || $role === 'Head Manager' || $role === 'Finance Manager') : ?> <!-- Replace '' with the role allowed to access Events -->
            <div class="dropdown">
                <a href="calendar.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'calendar.php' ? 'active' : ''; ?>">Events</a>
                <ul class="dropdown-menu">
                    <li><a href="manageAddon.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageAddon.php' ? 'active2' : ''; ?>">Manage Add-Ons</a></li>
                    <li><a href="viewHall.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'viewHall.php' ? 'active2' : ''; ?>">Manage Halls</a></li>
                    <li><a href="manageDiscounts.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageDiscounts.php' ? 'active2' : ''; ?>">Manage Discounts</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Supplies Section -->
        <?php if ($role === 'Event Manager' || $role === 'Head Manager') : ?> <!-- Replace '' with the role allowed to access Supplies -->
            <div class="dropdown">
                <a href="supplierM.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'supplierM.php' ? 'active' : ''; ?>">Supplies</a>
                <ul class="dropdown-menu">
                    <li><a href="manageFood.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageFood.php' ? 'active3' : ''; ?>">Manage Food</a></li>
                    <li><a href="manageMerchandise.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageMerchandise.php' ? 'active3' : ''; ?>">Manage Merchandise</a></li>
                    <li><a href="manageFoodSup.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageFoodSup.php' ? 'active3' : ''; ?>">Manage Food Supplier</a></li>
                    <li><a href="manageMerchan.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageMerchan.php' ? 'active3' : ''; ?>">Manage Merchandise Supplier</a></li>
                    <li><a href="manageInventory.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageInventory.php' ? 'active3' : ''; ?>">Manage Inventory</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Finance Section -->
        <?php if ($role === 'Finance Manager' || $role === 'Head Manager') : ?> <!-- Replace '' with the role allowed to access Finance -->
            <div class="dropdown">
                <a href="financeM.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'financeM.php' ? 'active' : ''; ?>">Finance</a>
                <ul class="dropdown-menu">
                    <li><a href="managePayments.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'managePayments.php' ? 'active2' : ''; ?>">View Payments</a></li>
                    <li><a href="manageExpense.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageExpense.php' ? 'active2' : ''; ?>">View Expenses</a></li>
                    <li><a href="manageReports.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageReports.php' ? 'active2' : ''; ?>">View Reports</a></li>
                    <li><a href="invoicegen.html" class="<?php echo basename($_SERVER['PHP_SELF']) === 'invoicegen.html' ? 'active2' : ''; ?>">Create Invoice</a></li>
                    <li><a href="404_admin.html" class="<?php echo basename($_SERVER['PHP_SELF']) === '404_admin.html' ? 'active2' : ''; ?>">Track Payments</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Staff Section -->
        <?php if ($role === 'Head Manager') : ?> <!-- Replace '' with the role allowed to access Staff -->
            <div class="dropdown">
                <a href="staffM.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'staffM.php' ? 'active' : ''; ?>">Staff</a>
                <ul class="dropdown-menu">
                    <li><a href="manageStaff.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageStaff.php' ? 'active2' : ''; ?>">Manage Staff</a></li>
                    <li><a href="manageManager.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageManager.php' ? 'active2' : ''; ?>">Manage Managers</a></li>
                    <li><a href="manageTasks.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageTasks.php' ? 'active2' : ''; ?>">Manage Tasks</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Additional Sections -->
        <?php if ($role === 'Head Manager' || $role === 'Event Manager') : ?> <!-- Replace '' with the role allowed to access Additional Sections -->
            <a href="manageResource.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageResource.php' ? 'active' : ''; ?>">Resource</a>
            <a href="manageClient.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageClient.php' ? 'active' : ''; ?>">Customer</a>
            <a href="feedback.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'feedback.php' ? 'active' : ''; ?>">Feedback</a>
            <a href="manageIssues.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manageIssues.php' ? 'active' : ''; ?>">Report Issues</a>
        <?php endif; ?>

        <!--Only for hiring staff-->
        <?php if ($role === 'Photographer' || $role === 'Graphic Designer') : ?> <!-- Replace '' with the role allowed to access Additional Sections -->
            <a href="viewResources.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'viewResources.php' ? 'active' : ''; ?>">View Resources</a>
            <a href="viewtasks.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'viewtasks.php' ? 'active' : ''; ?>">View Tasks</a>
        <?php endif; ?>

        <!--Only for photogpraher-->
        <?php if ($role === 'Photographer') : ?>
        <a href="viewResourceAllo.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'viewResourceAllo.php' ? 'active' : ''; ?>">View Resource Allocation</a>
        <?php endif; ?>
        
    </nav>
    <hr class="section-divider">
</aside>
<main>
