<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('Images/untitled design.jpg');
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin-left: 300px;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    h1 {
        color: #333;
    }
    p {
        color: #666;
    }
    .logout {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .logout:hover {
        background-color: #0056b3;
    }
        /* Sidebar */
    .custom-sidebar {
        width: 250px;
        background: #151515;
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        scrollbar-width: none;
    }

    .custom-sidebar::-webkit-scrollbar {
        display: none;
    }

    .custom-sidebar .logo img {
        display: block;
        margin: 0 auto 20px;
        max-width: 80%;
    }

    .custom-sidebar .menu {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .custom-sidebar .menu a {
        display: block;
        color: white;
        padding: 15px;
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
        display: none;
        padding-left: 15px;
        list-style: none;
        margin: 0;
    }

    .custom-sidebar .dropdown:hover .dropdown-menu {
        display: block;
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
    .images-section
    {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 20px;
    }

    .images-section img 
    {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    .images-section img:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }

    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <h1>Welcome to the Dashboard</h1>
        <p>Your role: <?php echo $_SESSION['role']; ?></p>

                <!-- Image Section -->
        <div class="images-section">
            <img src="Images/gap-event.jpg" alt="Gap HQ events">
            <img src="Images/alsogap.jpg" alt="Gap building">
            <img src="Images/gaphq-hall.jpg" alt="Gap HQ hall">
        </div>

        <br>
        <button class="logout" onclick="window.location.href='logoutadmin.php'">Logout</button>

    </div>
</body>
</html>
