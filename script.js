const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");

// Track events with a map
let events = {};

// getting new date, current year and month
let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

// Function to open a form
const openEventForm = (day) => {
  const eventKey = `${currYear}-${currMonth}-${day}`;
  const existingEvent = events[eventKey];

  // HTML for the event form, with fields populated if there's an existing event
  const formHtml = `
      <div class="event-form-container">
          <div class="event-form">
              <h3>${existingEvent ? `Edit Event` : `Add Event`} for ${months[currMonth]} ${day}, ${currYear}</h3>
              <label for="eventName">Event Name:</label>
              <input type="text" id="eventName" value="${existingEvent ? existingEvent.name : ''}" placeholder="Enter event name">
              <label for="eventTime">Event Time:</label>
              <input type="time" id="eventTime" value="${existingEvent ? existingEvent.time : ''}">
              <button id="saveEvent">${existingEvent ? 'Update' : 'Save'}</button>
              ${existingEvent ? '<button id="deleteEvent">Delete</button>' : ''}
              <button id="cancelEvent">Cancel</button>
          </div>
      </div>
  `;

  // Append the form to the body
  document.body.insertAdjacentHTML("beforeend", formHtml);

  // Add event listener for the Save or Update button
  document.getElementById("saveEvent").addEventListener("click", () => {
      const eventName = document.getElementById("eventName").value;
      const eventTime = document.getElementById("eventTime").value;

      if (eventName && eventTime) {
          // Save or update the event in the events object
          events[eventKey] = { name: eventName, time: eventTime };
          alert(`Event "${eventName}" at ${eventTime} ${existingEvent ? 'updated' : 'saved'} for ${months[currMonth]} ${day}, ${currYear}`);
          renderCalendar(); // Re-render calendar to show updated even
          window.location.href = "book.html";t
      } else {
          alert("Please fill in all fields.");
      }
      document.querySelector(".event-form-container").remove(); // Close the form
  });

  // Add event listener for the Delete button (if event exists)
  if (existingEvent) {
      document.getElementById("deleteEvent").addEventListener("click", () => {
          // Delete the event
          delete events[eventKey];
          alert(`Event for ${months[currMonth]} ${day}, ${currYear} deleted.`);
          renderCalendar(); // Re-render calendar to remove the event
          document.querySelector(".event-form-container").remove(); // Close the form
      });
  }

  // Add event listener for the Cancel button
  document.getElementById("cancelEvent").addEventListener("click", () => {
      document.querySelector(".event-form-container").remove(); // Close the form
  });
};



const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
        const eventKey = `${currYear}-${currMonth}-${i}`;
        const hasEvent = events[eventKey] ? "has-event" : ""; // Check if event exists for this day
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                     && currYear === new Date().getFullYear() ? "active" : "";
        liTag += `<li class="${isToday} ${hasEvent}" data-day="${i}">${i}</li>`;
    }

    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;

    // Add event listener to each day
    document.querySelectorAll(".days li:not(.inactive)").forEach(day => {
        day.addEventListener("click", () => {
            const dayNumber = day.getAttribute("data-day");
            openEventForm(dayNumber);
        });
    });
};

renderCalendar();

prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function
    });
});


