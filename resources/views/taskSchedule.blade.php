@extends('layout')
@section('content')
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
</head>
<body>

<div class="container">
    <br />
    <h1 class="text-center text-primary"><u>Schedule Maker</u></h1>
    <br />

    <div id="calendar"></div>

</div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="eventTitle" class="form-control" placeholder="Event Title">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="createEvent">Create</button>
        </div>
      </div>
    </div>
  </div>

<style>
    /* Custom CSS for the "Calorie Tracker" button */
    .custom-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        cursor: pointer;
        margin-right: 10px; /* Adjust the spacing as needed */
    }
    .calorie-event {
        background-color: red !important; /* Change the background color to red or any color you prefer */
        color: white; /* Change the text color to make it readable */
        border-radius: 3px; /* Add rounded corners if desired */
    }
    
    
</style>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: '/taskSchedule',
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Try');

                

                if (title) {
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                    $.ajax({
                        url: "/taskSchedule/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        success: function (data) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Created Successfully");
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    })
                }
            },
            eventResize: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;

                $.ajax({
                    url: "/taskSchedule/action",
                    type: "POST",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success: function (response) {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;

                $.ajax({
                    url: "/taskSchedule/action",
                    type: "POST",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success: function (response) {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },
            eventClick: function (event) {
                if (confirm("Are you sure you want to remove it?")) {
                    var id = event.id;
                    $.ajax({
                        url: "/taskSchedule/action",
                        type: "POST",
                        data: {
                            id: id,
                            type: "delete"
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Deleted Successfully");
                        }
                    })
                }
            }
        });

        // Create the "Calorie Tracker" button
        var calorieTrackerButton = $('<button>', {
        text: 'Calorie Tracker',
        class: 'custom-button',
        click: function () {
            
            var selectedDate = calendar.fullCalendar('getDate'); 

            var formattedDate = selectedDate.format('YYYY-MM-DD');

            var caloriesPageUrl = '/calorieTracker?date=' + formattedDate;

            window.location.href = caloriesPageUrl;
            
        }
    });

        
        var header = calendar.find('.fc-toolbar');
        header.find('.fc-center').append(calorieTrackerButton);
    });
</script>
</body>
</html>
@endsection
