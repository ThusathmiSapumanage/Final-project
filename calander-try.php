<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password
$dbname = "gaphq"; // Replace with your database name
$port = 3306;        // Default MySQL port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which button was clicked
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['saveEvent'])) {
        // Save Event
        $eventName = $_POST['eventName'];
        $eventType = $_POST['eventType'];
        $eventDate = $_POST['eventDate'];
        $eventStatus = $_POST['eventStatus'];
        

        // File uploads
        $nameTag = $_FILES['nameTag']['tmp_name'];
        $eventSchedule = $_FILES['eventSchedule']['tmp_name'];

        $nameTagContent = $nameTag ? addslashes(file_get_contents($nameTag)) : null;
        $eventScheduleContent = $eventSchedule ? addslashes(file_get_contents($eventSchedule)) : null;

        $sql = "INSERT INTO event (eventName, eventType, eventVisitDate, eventStatus, nameTagDesign, eventSchedule)
                VALUES ('$eventName', '$eventType', '$eventDate', '$eventStatus', '$nameTagContent', '$eventScheduleContent')";

        if ($conn->query($sql) === TRUE) {
            echo "Event saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['deleteEvent'])) {
        // Delete Event
        $eventId = $_POST['eventId'];

        $sql = "DELETE FROM event WHERE eventID = '$eventId'";

        if ($conn->query($sql) === TRUE) {
            echo "Event deleted successfully!";
        } else {
            echo "Error deleting event: " . $conn->error;
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Interactive Calendar</title>
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="styles.css" />
    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- manage AJAX requests -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- manage calendar events -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <style>
        .section-divider {
            margin: 20px 0;
            border: 1px solid #444;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            
            
        }

        #profile-img {
            width: 50px;  /* Adjust width to make the image smaller */
            height: 50px; /* Maintain aspect ratio by setting height */
            object-fit: cover; /* Ensures the image covers the box without distortion */
            border-radius: 50%; /* Makes the image circular */
            position: absolute;
            top: 120px;  /* Distance from the top */
            right: 50px; /* Distance from the right */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: adds a subtle shadow */
}


        .container {
            display: flex;
            height: 100vh;
        }

        .calendar-title {
            font-size: 24px;
            color: #F7941D;
            font-weight: bold;
        }

        .sidebar {
            width: 250px;
            background: #151515;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 175dvh;
        }

        .sidebar .menu a {
            display: block;
            color: #fff;
            padding: 14px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.5s ease;
            margin: 10px 0;
        }

        .sidebar .menu a.active, .sidebar .menu a:hover {
            background: #fdb827;
            color: #000;
        }

        .sidebar .settings {
            text-align: center;
            color: #fff;
            margin-top: auto;
            font-size: 14px;
            align-items: center;
        }

        /* Centering the calendar in the layout */
        .content {
            flex: 1; /* Allow the content to take up remaining space */
            display: flex;
            flex-direction: column; /* Stack controls and calendar vertically */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            padding: 20px;
            overflow: auto; /* Handle any extra content */
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: #F7941D;
            position: relative;
        }

        .header h1 {
            font-size: 24px;
        }

        .header .search {
            display: flex;
            align-items: center;
        }

        .header .search input {
            padding: 10px 35px;
            border-radius: 20px;
            border: none;
            width: 250px;
            margin-right: 10px;
        }

        .header .search button {
            padding: 10px;
            border: none;
            background: #fdb827;
            color: #000;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.5s ease;
            margin-left: 10px;
        }

        .header .search button:hover {
            background: rgb(255, 251, 0);
        }

        .search img {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            pointer-events: none;
        }

        .search {
            position: relative;
            display: inline-block;
        }

        .settings img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .settings {
            display: flex;
            justify-content: center;
            transition: background 0.5s ease;
            cursor: pointer;
        }

        .settings:hover {
            color: #F7941D;
        }
        .menu .dropdown-menu {
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
            background: #151515;
        }

        .menu .dropdown:hover .dropdown-menu {
            display: block;
            position: relative;
            padding-left: 20px;
        }

        .menu .dropdown-menu li a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.5s ease;
        }

        .menu .dropdown-menu li a:hover {
            background: #fdb827;
            color: #000;
        }

        .sidebar .menu a.active2, .sidebar .menu a.active2:hover {
            background: #27fdd9;
            color: #000;
        }

        .sidebar .menu a.active3:hover {
            background: #27fdd9;
            color: #000;
        }

        /* Ensure the calendar fits inside the content area */
        #calendar {
            max-width: 900px;
            width: 100%;
            height: 600px; /* Set a fixed height */
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: scroll; /* Ensure vertical scrolling */
            margin-top: 20px; /* Add space between controls and calendar */
        }

        #calendar::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Opera */
        }

        /* Make the content container take full space */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Stack controls and calendar vertically */
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: auto; /* Handle any extra content */
        }

        /* Flexbox fixes for height issues */
        .container {
            display: flex;
            flex-direction: row;
            height: 100vh;
        }

        /* New class for calendar controls */
        .calendar-controls {
            width: 100%;
            max-width: 900px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px; /* Space between controls and calendar */
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            position: relative;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .modal-footer button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-save {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-cancel {
            background-color: #9E9E9E;
            color: white;
        }

        .btn-save:hover { background-color: #45a049; }
        .btn-delete:hover { background-color: #d32f2f; }
        .btn-cancel:hover { background-color: #757575; }

        
    </style>
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
          <li><a href="#">Register</a></li>
        </ul>
        <div class="nav__btns">
          <button class="btn" onclick="redirectToLogin()">Sign In</button>
        </div>
    </nav>  
</head>
<body>

<a href="customerdata.html" target="_blank">
    <div id="profile-img">
        <img src="assets/profile-user.png" alt="Profile Image">
    </div>
</a>

    

    <div class="container">
        

        
        
        <!-- Calendar -->
        <div id="calendar"></div>

        <!-- Modal -->
        <div id="eventModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Event Details</h3>
                </div>
                <form id="eventForm">
                    <label for="eventName">Event Name:</label>
                    <input type="text" id="eventName" name="eventName" required><br><br>

                    <label for="eventType">Event Type:</label>
                    <select id="eventType" name="eventType" required>
                        <option value="Wedding">Wedding</option>
                        <option value="Birthday">Birthday</option>
                        <option value="Corporate">Corporate</option>
                        <option value="Other">Other</option>
                    </select><br><br>

                    <label for="visitDate">Visit Date:</label>
                    <input type="date" id="eventDate" name="eventDate"><br><br>

                    <label for="eventStatus">Event Status:</label>
                    <select id="eventStatus" name="eventStatus" required>
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                    </select><br><br>

                    <label for="nameTag">Name Tag Design:</label>
                    <input type="file" id="nameTag" name="nameTag"><br><br>

                    <label for="eventSchedule">Event Schedule:</label>
                    <input type="file" id="eventSchedule" name="eventSchedule"><br><br>

                    

                    <input type="hidden" id="eventStart" name="eventStart">
                    <input type="hidden" id="eventEnd" name="eventEnd">
                    <input type="hidden" id="eventId" name="eventId">

                    <div class="modal-footer">
                        <button type="submit" id="saveEvent" class="btn-save">Save Event</button>
                        <button type="button" id="deleteEvent" class="btn-delete">Delete Event</button>
                        <button type="button" id="closeModal" class="btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                // Reset the form
                $('#eventForm')[0].reset();
                $('#eventId').val('');
                $('#eventStart').val(start.format("YYYY-MM-DD HH:mm:ss"));
                $('#eventEnd').val(end.format("YYYY-MM-DD HH:mm:ss"));

                // Fetch dropdown options dynamically
                fetchDropdownOptions('manager', '#managerID');
                fetchDropdownOptions('hall', '#hallID');
                fetchDropdownOptions('client', '#clientID');

                // Show the modal as a popup
                $('#eventModal').fadeIn();
            },
            editable: true,
            eventClick: function (event) {
                // Populate form fields for editing
                $('#eventId').val(event.id);
                $('#eventName').val(event.title);
                $('#eventStart').val(event.start.format("YYYY-MM-DD HH:mm:ss"));
                $('#eventEnd').val(event.end ? event.end.format("YYYY-MM-DD HH:mm:ss") : '');

                // Fetch dropdown options dynamically
                fetchDropdownOptions('manager', '#managerID');
                fetchDropdownOptions('hall', '#hallID');
                fetchDropdownOptions('client', '#clientID');

                // Show the modal for editing
                $('#eventModal').fadeIn();
            },
            events: 'fetch_events.php'
        });

        // Handle form submission for saving or updating an event
        $('#eventForm').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const url = $('#eventId').val() ? 'update_event.php' : 'save_event.php';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert(response);
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#eventModal').fadeOut();
                },
                error: function () {
                    alert('Failed to save the event.');
                }
            });
        });

        // Handle event deletion
        $('#deleteEvent').on('click', function () {
            if (confirm('Are you sure you want to delete this event?')) {
                const eventId = $('#eventId').val();
                $.post('delete_event.php', { id: eventId }, function (response) {
                    alert(response);
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#eventModal').fadeOut();
                }).fail(function () {
                    alert('Failed to delete the event.');
                });
            }
        });

        // Close the modal
        $('#closeModal').on('click', function () {
            $('#eventModal').fadeOut();
        });

        // Fetch dropdown options dynamically
        function fetchDropdownOptions(type, selector) {
            $.get(`fetch_options.php?type=${type}`, function (data) {
                $(selector).html(data);
            }).fail(function () {
                alert(`Failed to load ${type} options.`);
            });
        }
    });
</script>

</body>

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
    <div class="footer__bar">
      Copyright © GAPHQ. All rights reserved.
    </div>
  </footer>
</html>
