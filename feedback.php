<!DOCTYPE html>
<html>
<head>
    <title>Feedback Management</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
*
{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body
{
    font-family: Arial, sans-serif;
    background-image: url('images/Untitled\ design.jpg');
    color: black;
    overflow: hidden; /* Hide scrollbars */
}

.container
{
    display: flex;
    height: 100vh;
}

/* Sidebar */
.custom-sidebar {
    width: 200px; /* Thinner sidebar */
    background: #151515;
    color: white;
    height: 100vh;
    position: fixed;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    scrollbar-width: none; /* For Firefox */
}

.custom-sidebar::-webkit-scrollbar {
    display: none; /* For Chrome, Safari, and Opera */
}

.custom-sidebar .logo img {
    display: block;
    margin: 0 auto 20px;
    max-width: 80%;
}

.custom-sidebar .menu {
    padding: 0;
    margin: 0;
    list-style: none; /* Removes bullet points */
}

.custom-sidebar .menu a {
    display: block;
    color: white;
    padding: 15px; /* Increased padding for more space between links */
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: background 0.3s;
}

.custom-sidebar .menu a.active,
.custom-sidebar .menu a:hover {
    background: #fdb827;
    color: black;
}

.custom-sidebar .dropdown-menu {
    display: none; /* Hide sub values */
    padding-left: 15px;
    list-style: none; /* Removes bullet points from submenus */
    margin: 0;
}

.custom-sidebar .dropdown:hover .dropdown-menu {
    display: block; /* Show sub values on hover */
}

.custom-sidebar .settings {
    margin-top: 20px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
}

.custom-sidebar .settings img {
    width: 20px;
    margin-right: 5px;
}

.content
{
    flex: 1;
    padding: 20px;
    margin-left: 250px; /* Adjust content margin to accommodate fixed sidebar */
    overflow-y: auto; /* Add vertical scroll */
}

.header
{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    color:#F7941D;
    position: relative;
}

.header h1
{
    font-size: 24px;
}

.header .search
{
    display: flex;
    align-items: center;
}

.header .search input
{
    padding: 10px 35px;
    border-radius: 20px;
    border: none;
    width: 250px;
    margin-right: 10px;

}

.header .search button
{
    padding: 10px;
    border: none;
    background: #fdb827;
    color: #000;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.5s ease;
    margin-left: 10px;
}

.header .search button:hover
{
    background: rgb(255, 251, 0);
}
.feedback
{
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 35px;
    width: 100%;
}

.list
{
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    background-color: rgba(255, 153, 0, 0.6);
    border-radius: 25px;    
    width: 100%;
    padding: 20px;
}

.feedback-card {
    position: relative; 
    width: calc(50% - 20px); /* Increase the width */
    background: #ffffff;
    color: #000;
    padding: 30px; 
    border-radius: 15px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Add smooth transition */
}

.feedback-card:hover {
    transform: scale(1.05); /* Keep the hover effect */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Optional shadow effect */
}


.search img
{
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 15px;
    pointer-events: none;
}

.search
{
    position: relative;
    display: inline-block;
}

.settings img
{
    width: 20px;
    height: 20px;
    margin-right: 10px;
}

.settings
{
    display: flex;
    justify-content: center;
    transition: background 0.5s ease;
    cursor: pointer;
}

.settings:hover
{
    color: #F7941D;
}

.section-divider
{
    margin-top: 30px;
    margin-bottom: 30px;
    border-color: #F7941D;
}

.feedback .list img
{
    width: 110px;
    height: 110px;
    padding: 15px;
}

.buttons button 
{
    background-color: #000;
    color: #fff; 
    border: none; 
    border-radius: 10px;
    padding: 10px 20px; 
    cursor: pointer; 
    transition: background 0.5s ease;
    position: absolute;
    bottom: 10px; 
    right: 10px; 
    display: flex;
    gap: 20px;
}

.buttons .del
{
    margin-left: 10px;
}

.buttons .del:hover
{
    background-color: #ff0000; 
    color: #ffffff;
}

.card-header .stars 
{
    font-size: 20px;
    color: #f7941d;
    text-align: center;
    margin-bottom: 10px;
}


.card-body h3 
{
    font-size: 18px; 
    font-weight: bold; 
    margin-bottom: 5px; 
    text-align: center; 
}

.card-body p 
{
    color: #666; 
    text-align: center;
    margin-bottom: 20px; 
}

.card-footer 
{
    display: flex; 
    align-items: center; 
    justify-content: flex-start;
    gap: 10px; 
}

.card-footer img 
{
    width: 40px; 
    height: 40px;
    border-radius: 50%;
}


.card-footer p
{
    font-size: 14px;
    font-weight: bold;
    margin: 0; 
}

.card-footer span 
{
    font-size: 12px;
    color: #666; 
}


.menu .dropdown-menu 
{
    display: none; 
    list-style: none; 
    padding: 0; 
    margin: 0; 
    background: #151515; 
}


.menu .dropdown:hover .dropdown-menu 
{
    display: block; 
    position: relative; 
    padding-left: 20px; 
}


.menu .dropdown-menu li a 
{
    display: block;
    color: #fff;
    padding: 10px;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.5s ease;
}


.menu .dropdown-menu li a:hover
{
    background: #fdb827;
    color: #000;
}


.sidebar .menu a.active2, .sidebar .menu a.active2:hover
{
    background: #27fdd9;
    color: #000;
}

.sidebar .menu a.active3:hover
{
    background: #27fdd9;
    color: #000;
}

.delete-btn {
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-btn:hover {
    background-color: #ff1a1a; /* Darker red on hover */
}

.approve-btn {
    background-color: #28a745; /* Green color */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.approve-btn:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: auto;
    padding: 20px;
    border-radius: 8px;
    width: 30%;
    position: relative;
    top: 20%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.modal-content h3 {
    margin: 0 0 20px;
    text-align: center;
}

.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.modal-content form label {
    font-weight: bold;
}

.modal-content form input[type="text"],
.modal-content form input[type="password"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.modal-content form button {
    padding: 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.modal-content form button[type="submit"] {
    background-color: #28a745;
    color: white;
}

.modal-content form button[type="button"] {
    background-color: #dc3545;
    color: white;
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
                <h1>Feedback Management</h1>
            </header>
            <section class="feedback">
                <h2 style="color: white;">Latest Reviews</h2> <!-- Changed text color to white -->
                <div class="list">
                    <?php
                    include "config.php";

                    $sql = "SELECT * FROM feedback ORDER BY feedbackDate DESC";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="feedback-card">';
                            echo '<h3>' . htmlspecialchars($row['feedbackName']) . '</h3>';
                            echo '<p>' . htmlspecialchars($row['feedbackDescription']) . '</p>';
                            echo '<p>Date: ' . htmlspecialchars($row['feedbackDate']) . '</p>';
                            echo '<p>Client ID: ' . htmlspecialchars($row['clientID']) . '</p>';
                            echo '</br> </br>';
                            echo '<button class="approve-btn" data-feedback-id="' . $row['feedbackID'] . '">Approve</button>';
                            echo '<button class="delete-btn" data-feedback-id="' . $row['feedbackID'] . '">Delete</button>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No feedback available.</p>';
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </section>
        </main>

        <!-- Approval Modal -->
        <div id="approvalModal" class="modal">
            <div class="modal-content">
                <h3>Approve Feedback</h3>
                <form id="approvalForm">
                    <label for="managerID">Manager ID:</label>
                    <input type="text" id="managerID" name="managerID" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <input type="hidden" id="feedbackID" name="feedbackID">

                    <div style="text-align: center; margin-top: 20px;">
                        <button type="submit">Approve</button>
                        <button type="button" id="closeModal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Open approval modal
            $('.approve-btn').on('click', function () {
                const feedbackId = $(this).data('feedback-id');
                $('#feedbackID').val(feedbackId);
                $('#approvalModal').fadeIn();
            });

            // Close approval modal
            $('#closeModal').on('click', function () {
                $('#approvalModal').fadeOut();
            });

            // Handle form submission for approval
            $('#approvalForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'approve_feedback.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function () {
                        alert('Approval failed.');
                    }
                });
            });
        });

        $(document).ready(function () {
        // Handle delete button click
        $('.delete-btn').on('click', function () {
            const feedbackId = $(this).data('feedback-id');
            if (confirm('Are you sure you want to delete this feedback?')) {
                $.ajax({
                    url: 'delete_feedback.php',
                    type: 'POST',
                    data: { feedbackID: feedbackId },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function () {
                        alert('Deletion failed.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>