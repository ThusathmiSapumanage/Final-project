<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
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
        <div class="nav_menu_btn" id="menu-btn">
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
    <div class="wrapper">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Database connection
          include "config.php";

          // Get form data
          $firstName = $conn->real_escape_string($_POST['firstName']);
          $lastName = $conn->real_escape_string($_POST['lastName']);
          $email = $conn->real_escape_string($_POST['email']);
          $password = $conn->real_escape_string($_POST['password']);

          // Password hashing
          $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

          // Insert data into the users table
          $sql = "INSERT INTO user (first_name, last_name, email, password) 
                  VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";

          if ($conn->query($sql) === TRUE) {
              echo "<p style='color: green;'>Registration successful! You can now <a href='login.php'>log in</a>.</p>";
          } else {
              echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
          }

          $conn->close();
      }
      ?>
      <form id="registerForm" action="" method="POST">
        <h2>Register</h2>
        <div class="input-field">
          <input type="text" id="firstName" name="firstName" required />
          <label for="firstName">First Name</label>
        </div>
        <div class="input-field">
          <input type="text" id="lastName" name="lastName" required />
          <label for="lastName">Last Name</label>
        </div>
        <div class="input-field">
          <input type="text" id="email" name="email" required />
          <label for="email">Enter Email</label>
        </div>
        <div class="input-field">
          <input type="password" id="password" name="password" required />
          <label for="password">Password</label>
        </div>
        <button type="submit">Register</button>
        <div class="register">
          <p>Have an account? <a href="login.php">Sign In</a></p>
        </div>
      </form>
    </div>
  </body>
</html>