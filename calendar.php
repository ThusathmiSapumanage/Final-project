<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interactive Calendar</title>
  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet">
  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f4f4;
    }
    #calendar {
      width: 90%;
      max-width: 900px;
      height: 90vh;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }
    .modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      width: 400px;
      max-height: 80vh;
      overflow-y: auto;
    }
    .modal.active {
      display: block;
    }
    .modal label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }
    .modal input,
    .modal select,
    .modal button {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .modal button {
      background: #007bff;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border: none;
    }
    .modal button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div id="calendar"></div>
  
  <!-- Modal for Add/Edit Event -->
  <div id="eventModal" class="modal">
    <form id="eventForm">
      <input type="hidden" id="eventID" name="eventID">

      <label for="eventName">Event Name</label>
      <input type="text" id="eventName" name="eventName" required>

      <label for="eventStart">Start Date & Time</label>
      <input type="datetime-local" id="eventStart" name="eventStart" required>

      <label for="eventEnd">End Date & Time</label>
      <input type="datetime-local" id="eventEnd" name="eventEnd" required>

      <label for="ClientID">Client</label>
      <select id="ClientID" name="ClientID" required></select>

      <label for="EmanagerID">Event Manager</label>
      <select id="EmanagerID" name="EmanagerID" required></select>

      <label for="hallID">Hall</label>
      <select id="hallID" name="hallID" required></select>

      <button type="submit">Save</button>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const calendarEl = document.getElementById("calendar");
      const eventModal = document.getElementById("eventModal");
      const eventForm = document.getElementById("eventForm");

      // Initialize FullCalendar
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "timeGridWeek,dayGridMonth"
        },
        slotMinTime: "00:00:00",
        slotMaxTime: "20:00:00",
        allDaySlot: false,
        selectable: true,
        events: "fetch-events.php", // Load events from the backend
        select: function (info) {
          // Open modal for new event creation
          eventModal.classList.add("active");
          eventForm.reset();

          // Populate the start and end date-time fields with the selected time range
          document.getElementById("eventStart").value = info.start.toISOString().slice(0, 16);
          document.getElementById("eventEnd").value = info.end.toISOString().slice(0, 16);
        },
        eventClick: function (info) {
          // Open modal for editing an existing event
          const event = info.event;
          eventModal.classList.add("active");

          // Populate the form with the selected event data
          document.getElementById("eventID").value = event.id;
          document.getElementById("eventName").value = event.title;
          document.getElementById("eventStart").value = event.start.toISOString().slice(0, 16);
          document.getElementById("eventEnd").value = event.end.toISOString().slice(0, 16);
          document.getElementById("ClientID").value = event.extendedProps.ClientID || "";
          document.getElementById("EmanagerID").value = event.extendedProps.EmanagerID || "";
          document.getElementById("hallID").value = event.extendedProps.hallID || "";
        }
      });

      calendar.render();

      // Populate dropdowns
      const populateDropdowns = async () => {
        try {
          const response = await fetch("fetch-options2.php");
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          const data = await response.json();

          // Populate Client dropdown
          const clientSelect = document.getElementById("ClientID");
          clientSelect.innerHTML = '<option value="">Select Client</option>';
          data.clients.forEach((client) => {
            const option = document.createElement("option");
            option.value = client.clientID;
            option.textContent = client.clientName;
            clientSelect.appendChild(option);
          });

          // Populate Event Manager dropdown
          const managerSelect = document.getElementById("EmanagerID");
          managerSelect.innerHTML = '<option value="">Select Event Manager</option>';
          data.managers.forEach((manager) => {
            const option = document.createElement("option");
            option.value = manager.managerID;
            option.textContent = manager.mName;
            managerSelect.appendChild(option);
          });

          // Populate Hall dropdown
          const hallSelect = document.getElementById("hallID");
          hallSelect.innerHTML = '<option value="">Select Hall</option>';
          data.halls.forEach((hall) => {
            const option = document.createElement("option");
            option.value = hall.hallID;
            option.textContent = hall.hallName;
            hallSelect.appendChild(option);
          });
        } catch (error) {
          console.error("Failed to populate dropdowns:", error);
        }
      };

      populateDropdowns(); // Call the function to populate dropdowns

      // Handle form submission
      eventForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(eventForm);
        const isUpdate = formData.get("eventID");

        fetch(isUpdate ? "update-event.php" : "add-event.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              calendar.refetchEvents();
              eventModal.classList.remove("active");
            } else {
              alert(data.error || "An error occurred!");
            }
          });
      });
    });
  </script>
</body>
</html>
