<?php
session_start();

// Check if the client is logged in
if (!isset($_SESSION['clientID'])) {
    header("Location: client_login.php");
    exit;
}

// Retrieve logged-in client ID
$clientID = $_SESSION['clientID'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interactive Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        #calendar {
            margin: 20px auto;
            max-width: 900px;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #eventModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-height: 90%;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal-footer {
            text-align: right;
        }

        .btn-save {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #FF5733;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #9E9E9E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div id="calendar"></div>

    <!-- Modal -->
    <div id="eventModal">
        <div class="modal-content">
            <form id="eventForm" enctype="multipart/form-data">
                <label for="eventName">Event Name:</label>
                <input type="text" id="eventName" name="eventName" required>

                <label for="eventType">Event Type:</label>
                <select id="eventType" name="eventType" required>
                    <option value="Wedding">Wedding</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Corporate">Corporate</option>
                    <option value="Other">Other</option>
                </select>

                <label for="eventVisitDate">Visit Date:</label>
                <input type="date" id="eventVisitDate" name="eventVisitDate" required>

                <label for="hallDropdown">Hall:</label>
                <select id="hallDropdown" name="hallID" required></select>

                <label for="nameTagDesign">Name Tag Design:</label>
                <input type="file" id="nameTagDesign" name="nameTagDesign">

                <label for="eventSchedule">Event Schedule:</label>
                <input type="file" id="eventSchedule" name="eventSchedule">

                <input type="hidden" name="eventID" id="eventID">
                <input type="hidden" name="eventStart" id="hiddenEventStart">
                <input type="hidden" name="eventEnd" id="hiddenEventEnd">

                <div class="modal-footer">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" id="deleteEvent" class="btn-delete">Delete</button>
                    <button type="button" class="btn-cancel" id="closeModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let selectedStart, selectedEnd;

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                select: function (start, end) {
                    selectedStart = start.format("YYYY-MM-DDTHH:mm");
                    selectedEnd = end.format("YYYY-MM-DDTHH:mm");

                    $('#hiddenEventStart').val(selectedStart);
                    $('#hiddenEventEnd').val(selectedEnd);

                    $('#eventForm')[0].reset();
                    $('#eventID').val('');
                    $('#eventModal').fadeIn();
                },
                events: 'fetch_events_clients.php',
                editable: true,
                eventClick: function (event) {
                    $('#eventID').val(event.id);
                    $('#eventName').val(event.title);
                    $('#hiddenEventStart').val(event.start.format("YYYY-MM-DDTHH:mm"));
                    $('#hiddenEventEnd').val(event.end ? event.end.format("YYYY-MM-DDTHH:mm") : '');
                    $('#eventModal').fadeIn();
                }
            });

            // Load hall names dynamically
            $.get('fetch_halls.php', function (data) {
                $('#hallDropdown').html(data);
            });

            // Save or update event
            $('#eventForm').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: 'save_or_update_event.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        alert(response);
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#eventModal').fadeOut();
                    },
                    error: function () {
                        alert('An error occurred while saving the event.');
                    }
                });
            });

            // Delete event
            $('#deleteEvent').on('click', function () {
                const eventID = $('#eventID').val();
                if (eventID) {
                    if (confirm('Are you sure you want to delete this event?')) {
                        $.ajax({
                            url: 'delete_event_forcli.php',
                            method: 'POST',
                            data: { eventID },
                            success: function (response) {
                                alert(response);
                                $('#calendar').fullCalendar('refetchEvents');
                                $('#eventModal').fadeOut();
                            },
                            error: function () {
                                alert('An error occurred while deleting the event.');
                            }
                        });
                    }
                } else {
                    alert('No event selected for deletion.');
                }
            });

            // Close modal
            $('#closeModal').on('click', function () {
                $('#eventModal').fadeOut();
            });
        });
    </script>
</body>
</html>
