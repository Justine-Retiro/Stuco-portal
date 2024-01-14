<?php 
include '../api/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Calendar</title>
    <link rel="stylesheet" href="style.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
          });
          calendar.render();
        });
  
      </script>
</head>
<body class="bg-light">
    <?php include "../components/sidebar.php";?>

     <div id='calendar'></div>

     <script>
        document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true, 
        events: [], 

        eventClick: function (info) {

            var event = info.event;
            var action = prompt('Choose an action: Edit / Delete', 'Edit');
            if (action.toLowerCase() === 'edit') {
                handleEditEvent(event);
            } else if (action.toLowerCase() === 'delete') {
                calendar.getEventById(event.id).remove();
            }
        },

        dateClick: function (info) {
            var title = prompt('Enter Event Title:');
            if (title) {
                var newEvent = {
                    title: title,
                    start: info.dateStr,
                    allDay: true,
                    backgroundColor: getRandomColor()
                };
                calendar.addEvent(newEvent);
            }
        }
    });

    calendar.render();

    function handleEditEvent(event) {
        var newTitle = prompt('Edit Event Title:', event.title);
        if (newTitle !== null) {
            event.setProp('title', newTitle);
        }

        var newBackgroundColor = prompt('Edit Event Background Color (hex format):', event.backgroundColor);
        if (newBackgroundColor !== null) {
            event.setProp('backgroundColor', newBackgroundColor);
        }

        var newTextColor = prompt('Edit Event Text Color (hex format):', event.textColor);
        if (newTextColor !== null) {
            event.setProp('textColor', newTextColor);
        }
    }

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
});

     </script>
</body>
</html>