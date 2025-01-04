<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT clientID, clientPass FROM client WHERE cEmail = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $client = mysqli_fetch_assoc($result);

        if ($password === $client['clientPass']) { // Match plain password (consider hashing for production)
            $_SESSION['clientID'] = $client['clientID'];
            header("Location: calendar-try.php");
            exit;
        } else {
            header("Location: client_login.php?error=Invalid password.");
            exit;
        }
    } else {
        header("Location: client_login.php?error=Email not found.");
        exit;
    }
} else {
    header("Location: client_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Client Login</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
        <form action="client_login_action.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
