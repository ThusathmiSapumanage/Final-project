<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $bstart = $_POST['bstart'];
  $bend = $_POST['bend'];
  $bname = $_POST['bname'];
  $bprice = $_POST['bprice'];
  $btype = $_POST['btype'];
  $hallid = $_POST['hallid'];
  $clientid = $_POST['clientid'];
  $managerid = $_POST['managerid'];

  $sql = "INSERT INTO booking (bStartDate, bEndDate, bName, bPrice, bType, hallID, clientID, managerID) VALUES ('$bstart', '$bend', '$bname', '$bprice', '$btype', '$hallid', '$clientid', '$managerid')";

    if (mysqli_query($conn, $sql)) {
        header("Location: payment.html");
        exit;
    } 
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT managerID FROM manager";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT hallID FROM hall";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT clientID FROM cusprofile";
$result3 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="book.css" />

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
        <li><a href="testimonials.html">Testimonials</a></li>
        <li><a href="#"></a></li>
      </ul>
      <div class="nav__btns">
        <button class="btn" onclick="redirectToLogin()">Sign In</button>
      </div>
      <script>
        function redirectToLogin() {
          window.location.href = "login.html";
        }
      </script>
    </nav>
    <script>
      window.onload = function () {
        // Retrieve the selected package from localStorage
        const selectedPackage = localStorage.getItem("selectedPackage");
        if (selectedPackage) {
          document.getElementById("selection").textContent = selectedPackage;
        } else {
          document.getElementById("selection").textContent =
            "No package selected.";
        }
      };
    </script>
    <style>
      /* Internal CSS for advertisements */
      .ad-container {
        width: 25%; /* Reduced the width to make it smaller */
        padding: 10px; /* Adjusted padding for smaller size */
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .ad {
        padding: 8px;
        border-radius: 8px;
        color: white;
        font-size: 12px; /* Smaller font size */
        text-align: center;
        font-weight: bold;
      }

      .ad.one {
        background-color: #ff5722;
      }

      .ad.two {
        background-color: #2196f3;
      }

      .ad p {
        margin: 0;
        font-size: 12px;
      }
    </style>
  </head>
  <body>
    <section>
      <!-- Advertisement Section -->
      <div class="ad-container">
        <div class="ad one">
          <p>Get 20% Off on Your First Booking!</p>
          <p>Use Code: NEWUSER</p>
        </div>
        <div class="ad two">
          <p>Special Discount for Event Packages!</p>
          <p>Save 30% on Weddings & Conferences!</p>
        </div>
      </div>
      <form action="" method="POST" class="form-container">

        <div class="form-group">

          <label for="btype">Booking Type:</label>
          <select id = "btype" name = "btype">
            <option value = "Tentative">Tentative</option>
            <option value = "Confirmed">Confirmed</option>
          </select></br></br>

          <label for="bstart">Booking Start Date:</label>
          <input type="date" id="bstart" name="bstart" required />

          <label for="bend">Booking End Date:</label>
          <input type="date" id="bend" name="bend" required />

          <label for="bname">Booking Name:</label>
          <input type="text" id="bname" name="bname" required />

          <label for="bprice">Booking Price:</label>
          <input type="text" id="bprice" name="bprice" required /></br>

          <label for="hallid">Hall ID:</label>
          <select id="hallid" name="hallid">

            <?php
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<option value = " . $row['hallID'] . ">" . $row['hallID'] . "</option>";
                }
            }
            ?>
          </select></br></br>

          <label for="clientid">Client ID:</label>
          <select id="clientid" name="clientid">
            <?php
            if (mysqli_num_rows($result3) > 0) {
                while ($row = mysqli_fetch_assoc($result3)) {
                    echo "<option value = " . $row['clientID'] . ">" . $row['clientID'] . "</option>";
                }
            }
            ?>
          </select></br></br>

          <label for="managerid">Manager ID:</label>
          <select id="managerid" name="managerid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value = " . $row['managerID'] . ">" . $row['managerID'] . "</option>";
                }
            }
            ?>
          </select></br></br>
        
        <div class="form-group">
          <label for="merchandise">Merchandise:</label>
          <ul class="quick-links">
            <p id="selection"></p>
            <li>
              <a href="/viewMerchandise.html" target="_blank">View Merchandise</a>
            </li>
          </ul>
        </div>

        <div class="form-group">
          <label>Quick Links:</label>
          <ul class="quick-links">
            <li><a href="/faqs.html" target="_blank">View FAQs</a></li>
            <li>
              <a href="/pastbookings.html" target="_blank">View Past Booking</a>
            </li>
            <li>
              <a href="/rentalpackages.html" target="_blank">View Prices</a>
            </li>
          </ul>
        </div>

        <div class="form-group">
          <!-- Set type="button" to prevent form submission -->
          <button type="button" class="btn" onclick="redirectTopayment()">
            Proceed to Checkout
          </button>
        </div>

        <script>
          // JavaScript function to redirect the user
          function redirectTopayment() {
            window.location.href = "payment.html"; // This will redirect to payment.html
          }
        </script>
      </form>
    </section>
    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="footer__logo">
            <a href="#" class="logo">
              <img src="" />
              <span>GAPHQ</span>
            </a>
          </div>

          <ul class="footer__socials">
            <li>
              <a href="#"><i class="ri-facebook-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-twitter-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-linkedin-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-instagram-line"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-youtube-fill"></i></a>
            </li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Our Services</h4>
          <ul class="footer__links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="rentalpackages.html">Rental packages</a></li>
            
            <li><a href="testimonials.html">Testimonials</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>rental packages</h4>
          <ul class="footer__links">
            <li><a href="rentalpackages.html">Package 1</a></li>
            <li><a href="rentalpackages.html">Package 2</a></li>
            <li><a href="rentalpackages.html">Package 3</a></li>
            <li><a href="rentalpackages.html">Package 4</a></li>
            <li><a href="rentalpackages.html">Package 5</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Contact</h4>
          <ul class="footer__links">
            <li>
              <a href="#">
                <span><i class="ri-phone-fill"></i></span> +91 0987654321
              </a>
            </li>
            <li>
              <a href="#">
                <span><i class="ri-map-pin-fill"></i></span> Sri Lanka,Colombo
              </a>
            </li>
            <li>
              <a href="#">
                <span><i class="ri-mail-fill"></i></span> gaphq@gmail.com
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer__bar">Copyright © GAPHQ. All rights reserved.</div>
    </footer>
  </body>
</html>
