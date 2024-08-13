<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png"
        href="https://png.pngtree.com/png-clipart/20240416/original/pngtree-hanging-calendar-illustration-png-image_14839196.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #00bcd4, #009688);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 40px auto;
            max-width: 1200px;
        }

        .container,
        .container-sidebar {
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            transition: all 0.4s ease-in-out;
        }

        .container:hover,
        .container-sidebar:hover {
            transform: scale(1.05);
        }

        .container {
            max-width: 70%;
        }

        .container-sidebar {
            max-width: 500px;
        }

        h1 {
            font-size: 3rem;
            color: #00acc1;
            text-align: center;
            margin-bottom: 40px;
        }

        #calendar {
            margin-top: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 15px;
            width: 100%;
            height: 500px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #00acc1;
            color: #ffffff;
            border-bottom: none;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-footer {
            border-top: none;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .btn {
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #00acc1;
            border-color: #00acc1;
        }

        .btn-primary:hover {
            background-color: #00838f;
            border-color: #00838f;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .btn-danger {
            background-color: #f44336;
            border-color: #f44336;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }

        #calendar .fc-event {
            color: #ffffff;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
        }

        #calendar .fc-header {
            background-color: #00acc1;
            color: #ffffff;
        }

        #calendar .fc-event:hover {
            background-color: #00838f;
        }

        #calendar .fc-day-grid-event {
            border-radius: 5px;
        }

        .btn {
            color: white;
        }

        .clock {
            font-family: 'Helvetica Neue', sans-serif;
            color: #333;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 440px;
            height: 100px;
            text-align: center;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 24px;
            font-weight: 300;

        }

        .clock .time {
            font-size: 30px;
            font-weight: bold;
        }

        .clock .date {
            font-size: 18px;
            color: #888;
            font-weight: bold;
        }

        .toast-info {
            background-color: #00838f;
        }
        .details {
            max-height: 480px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <div class="container">
            <h1>Calendar</h1>
            <a href="{{ route('events.list') }}" class="btn btn-primary mb-3">Search Events</a>
            <a href="{{ url('kontak') }}" class="btn btn-secondary mb-3">Contact</a>
            <a href="{{ url('login') }}" class="btn btn-primary mb-3">Login</a>

            <div id="calendar"></div>
        </div>
        <div class="container-sidebar">
            <h1>Events</h1>
            <div id="eventDetails">
                <!-- Detail event lainnya -->
                <div id="eventImageWrapper" style="display:none;">
                    <h4>Event Image</h4>
                    <img id="eventImage" src="" alt="Event Image" style="max-width: 100%; border-radius: 8px;">
                </div>
            </div>
            <div id="liveClock" class="mt-3 clock"></div> <!-- Menambahkan elemen untuk jam -->
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
    $(document).ready(function() {
    var SITEURL = "{{ url('/') }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize FullCalendar
    $('#calendar').fullCalendar({
        editable: false,
        events: SITEURL + "/events",
        displayEventTime: false,
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            var today = moment().startOf('day');
            if (start.isBefore(today)) {
                alert('Cannot book for past dates.');
                $('#calendar').fullCalendar('unselect');
                return;
            }

            var adjustedEnd = end.subtract(1, 'days');

            $('#eventModal').find('.modal-title').text('Add Event');
            $('#eventModal').find('#eventForm')[0].reset();
            $('#eventModal').find('#eventId').val('');
            $('#eventModal').find('#eventStart').val(start.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventModal').find('#eventEnd').val(adjustedEnd.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventModal').find('#removeEventBtn').hide();
            $('#eventModal').find('#editEventBtn').hide();
            $('#eventModal').find('#saveEventBtn').show();
            $('#eventModal').find('#showEventBtn').hide();
            $('#eventModal').modal('show');
        },
        eventClick: function(event) {
            console.log("Event clicked:", event);

            var adjustedEnd = moment(event.end).subtract(1, 'days');

            $('#eventModal').find('.modal-title').text('Edit Event');
            $('#eventModal').find('#eventId').val(event.id);
            $('#eventModal').find('#eventTitle').val(event.title);
            $('#eventModal').find('#eventStart').val(event.start.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventModal').find('#eventEnd').val(adjustedEnd.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventModal').find('#eventDescription').val(event.description);
            $('#eventModal').find('#eventRoom').val(event.room);
            $('#eventModal').find('#eventShirt').val(event.shirt);

            var adjustedEndForShow = moment(event.end).subtract(1, 'days');
            $('#eventModal').find('#showEventBtn').attr('href', SITEURL + "/events/" + event.id + "?end=" + adjustedEndForShow.format('YYYY-MM-DD')).show();

            $('#eventModal').find('#removeEventBtn').show();
            $('#eventModal').find('#editEventBtn').show();
            $('#eventModal').find('#saveEventBtn').hide();

            // Populate Sidebar
            var eventDetailsHtml = `
             <div class="details">
                <h3>${event.title}</h3>
                <p><strong>Start:</strong> ${event.start.format('YYYY-MM-DD HH:mm:ss')}</p>
                <p><strong>End:</strong> ${adjustedEnd.format('YYYY-MM-DD HH:mm:ss')}</p>
                <p><strong>Room:</strong> ${event.room || 'N/A'}</p>
                <p><strong>Shirt:</strong> ${event.shirt || 'N/A'}</p>
                <p><strong></strong> ${event.image ? `<img src="${SITEURL}/storage/images/${event.image}" alt="Event Image" style="max-width: 400px; max-height: 250px;">` : 'No image'}</p>
                <p><strong>Description:</strong> ${event.description || 'N/A'}</p>
                </div>
            `;
            $('#eventDetails').html(eventDetailsHtml);

            $('#updateEventSidebarBtn').show();
        },

        viewRender: function(view, element) {
            checkTodaysEvents();
        },

        eventAfterRender: function(event, element, view) {
            checkTodaysEvents();
        }

        
    });

    $('#updateEventSidebarBtn').click(function() {
        $('#eventModal').modal('show');
    });

    $('#showEventBtn').click(function() {
        window.location.href = $(this).attr('href');
    });
    

   function checkTodaysEvents() {
        $.ajax({
            url: SITEURL + '/todays-events',
            type: 'GET',
            success: function(events) {
                if (events.length > 0) {
                    toastr.info('You have events scheduled for today!', 'Reminder');
                }
            },
            error: function(xhr) {
                console.error('Error fetching today\'s events:', xhr.responseText);
            }
    });
}


    function updateClock() {
        var now = moment();
        var timeString = now.format('h:mm:ss A');
        var dateString = now.format('dddd, MMMM D, YYYY');

        $('#liveClock').html(
            `<div class="time">${timeString}</div>
             <div class="date">${dateString}</div>`
        );
    }

    updateClock();
    setInterval(updateClock, 1000);

});



    </script>
</body>

</html>
