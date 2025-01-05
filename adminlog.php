<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Check if it's a Manager ID
    if (str_starts_with($id, "EID") || str_starts_with($id, "FID") || str_starts_with($id, "HID")) {
        $sql = "SELECT * FROM manager WHERE managerID = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $manager = mysqli_fetch_assoc($result);
            if ($manager['mPassword'] === $password) {
                // Set a session variable for the manager role
                session_start();
                $_SESSION['role'] = $id[0] === "E" ? "Event Manager" :
                                    ($id[0] === "F" ? "Finance Manager" : "Head Manager");
                $_SESSION['id'] = $id;
                header("Location: dash.php");
                exit;
            } else {
                echo "<script>alert('Invalid Password.');</script>";
            }
        } else {
            echo "<script>alert('Manager ID not found.');</script>";
        }
    }
    // Check if it's a Staff ID
    elseif (str_starts_with($id, "PSID") || str_starts_with($id, "GDID")) {
        $sql = "SELECT * FROM hiringstaff WHERE staffID = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $staff = mysqli_fetch_assoc($result);
            if ($staff['staffPassword'] === $password) {
                // Set a session variable for the staff role
                session_start();
                $_SESSION['role'] = str_starts_with($id, "PS") ? "Photographer" : "Graphic Designer";
                $_SESSION['id'] = $id;
                header("Location: dash.php");
                exit;
            } else {
                echo "<script>alert('Invalid Password.');</script>";
            }
        } else {
            echo "<script>alert('Staff ID not found.');</script>";
        }
    } else {
        echo "<script>alert('Invalid ID format.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
      body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }

    h1 {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      text-align: left;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" placeholder="Enter your ID" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
