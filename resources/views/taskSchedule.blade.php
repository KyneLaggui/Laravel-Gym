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
    <h1 class="text-center text-primary text-5xl">Schedule Maker</h1>
    <br />

    <div id="calendar"></div>

</div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Create Schedule</h5>
          <button type="button" class="btn btn-primary float-end" id="calorieTrackerButton">Calorie Tracker</button>
          
        </div>
        <div class="modal-body">
          <input type="text" id="eventTitle" class="form-control mb-3" placeholder="Create Schedule">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
          <button type="button" class="btn btn-primary" id="createEvent">Create</button>
        </div>
      </div>
    </div>
</div>

<style>
    
    .custom-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        cursor: pointer;
        margin-right: 10px; 
    }
    .fc-content, .fc-state-active {
        background-color: #007bff;
        color: white;
    }
    .swal2-cancel {
        margin-right: 1em !important;
    }
    
    
    
    
</style>

<script>

    function closeModal()
    {
        $('#eventModal').modal('hide');
    }

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
            select: function (date, jsEvent, view) {
                var selectedDate = date.format('YYYY-MM-DD HH:mm:ss');
                

                $('#eventModal').modal('show');
                
                $('#createEvent').off('click').on('click', function () {
                    var title = $('#eventTitle').val();
                    if (title) {

                        var start = selectedDate;
                        var end = selectedDate; 

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
                                
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                    })
                            
                                    Toast.fire({
                                    icon: 'success',
                                    title: 'Schedule Added'
                                })
               
                                closeModal(); 
                                $('#eventTitle').val(''); 
                            },
                            error: function (xhr, status, error) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                    })
                            
                                    Toast.fire({
                                    icon: 'error',
                                    title: 'Error'
                                })
                            }
                        });

                    }
                });

                $('#calorieTrackerButton').click(function () {
                    
                    var formattedDate = moment(selectedDate).format('YYYY-MM-DD');
                    var caloriesPageUrl = '/calorieTracker?date=' + formattedDate;
                    window.location.href = caloriesPageUrl;
                    
                    $('#eventModal').modal('hide');
                });

               
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
                        const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                    })
                            
                                    Toast.fire({
                                    icon: 'success',
                                    title: 'Schedule Updated'
                                })
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
                        calendar.fullCalendar('refetchEvents');
                        const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                    })
                            
                                    Toast.fire({
                                    icon: 'success',
                                    title: 'Schedule Updated'
                                })
                    }
                })
            },
            eventClick: function (event) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
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
                                
                            }
                        })
                        swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your Schedule has been deleted.',
                        'success'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Schedules are safe',
                        'error'
                        )
                    }
                })
                
            }
        });

        


        
        
    });
</script>
</body>
</html>
@endsection
