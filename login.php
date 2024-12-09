<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="styles.css" />
    <nav>
      <div class="nav__header">
        <div class="nav__logo">
          <a href="#" class="logo">
            <img src="assets/logo.jpg" alt="logo" class="logo-white" />
            <img src="assets/logo.jpg" alt="logo" class="logo-dark" />
            <span>GAPHQ</span>
          </a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <i class="ri-menu-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="rentalpackages.html">Rental packages</a></li>
        <li><a href="#client">Testimonials</a></li>
        <li><a href="#"></a></li>
      </ul>
      <div class="nav__btns">
        <button class="btn">Sign In</button>
      </div>
    </nav>
  </head>
  <body>
    <?php
    // Start the session
    session_start();

    // Database connection configuration
    $servername = "localhost";
    $username = "root";
    $password = ""; // Replace with your MySQL root password if applicable
    $dbname = "final";

    // Establish connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Define variables to hold error or success messages
    $message = "";

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize form inputs
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate inputs
        if (empty($email) || empty($password)) {
            $message = "<p style='color:red;'>Please fill in both fields.</p>";
        } else {
            // Prepare SQL statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM login WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch user data
                $user = $result->fetch_assoc();

                // Check if the password matches (use password_verify if hashed)
                if ($password === $user['password']) {
                    $_SESSION['email'] = $user['email']; // Store session data
                    header("Location: dashboard.php"); // Redirect to the dashboard
                    exit();
                } else {
                    $message = "<p style='color:red;'>Incorrect password.</p>";
                }
            } else {
                $message = "<p style='color:red;'>No account found with this email.</p>";
            }

            $stmt->close(); // Close the statement
        }
    }

    // Close the database connection
    $conn->close();
    ?>
    <div class="wrapper">
      <form id="loginForm" action="" method="POST">
        <h2>Login</h2>
        <div class="input-field">
          <input type="text" id="email" name="email" />
          <label for="email">Enter your email</label>
        </div>
        <div class="input-field">
          <input type="password" id="password" name="password" />
          <label for="password">Enter your password</label>
        </div>
        <div class="forget">
          <label for="remember">
            <input type="checkbox" id="remember" />
            <p>Remember me</p>
          </label>
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit">Log In</button>
        <div class="register">
          <p>Don't have an account? <a href="register.html">Register</a></p>
        </div>
        <?php
        // Display the message, if any
        if (!empty($message)) {
            echo $message;
        }
        ?>
      </form>
    </div>
  </body>
</html>
