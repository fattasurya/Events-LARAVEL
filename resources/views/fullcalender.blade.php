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
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #00bcd4, #009688);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 30px;
            border-radius: 12px;
            max-width: 1000px;
            margin: 40px auto;
            transition: all 0.4s ease-in-out;
        }

        .container:hover {
            transform: scale(1.05);
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
            height: 700px;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Calendar</h1>
        <a href="{{ route('events.list') }}" class="btn btn-primary mb-3">Search Events</a>
        <a href="{{ url('kontak') }}" class="btn btn-secondary mb-3">Contact</a>
        <div id="calendar"></div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        <div class="form-group">
                            <label for="eventTitle">Title</label>
                            <input type="text" class="form-control" id="eventTitle" placeholder="Enter Title"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="eventStart">Start</label>
                            <input type="text" class="form-control" id="eventStart" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="eventEnd">End</label>
                            <input type="text" class="form-control" id="eventEnd" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="eventDescription">Description</label>
                            <textarea class="form-control" id="eventDescription" rows="3" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="eventRoom">Room</label>
                            <select class="form-control" id="eventRoom">
                                <option value="">Select Room</option>
                                <option value="Room 1">Room 1</option>
                                <option value="Room 2">Room 2</option>
                                <option value="Room 3">Room 3</option>
                                <option value="Room 4">Room 4</option>
                                <option value="Room 5">Room 5</option>
                                <option value="Room 6">Room 6</option>
                                <option value="Room 7">Room 7</option>
                                <option value="Room 8">Room 8</option>
                                <option value="Room 9">Room 9</option>
                                <option value="Room 10">Room 10</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventShirt">Shirt</label>
                            <input type="text" class="form-control" id="eventShirt" placeholder="Enter Shirt">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="removeEventBtn"
                        style="display:none;">Delete</button>
                    <button type="button" class="btn btn-warning" id="editEventBtn"
                        style="display:none;">Update</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn">Save</button>
                    <!-- New Show Button -->
                    <a href="#" class="btn btn-info" id="showEventBtn">Show</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#calendar').fullCalendar({
                editable: true,
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

                    // Set End Date to be one day less
                    var adjustedEnd = end.subtract(1, 'days');

                    $('#eventModal').find('.modal-title').text('Add Event');
                    $('#eventModal').find('#eventForm')[0].reset();
                    $('#eventModal').find('#eventId').val('');
                    $('#eventModal').find('#eventStart').val(start.format('YYYY-MM-DD HH:mm:ss'));
                    $('#eventModal').find('#eventEnd').val(adjustedEnd.format('YYYY-MM-DD HH:mm:ss'));
                    $('#eventModal').find('#removeEventBtn').hide();
                    $('#eventModal').find('#editEventBtn').hide();
                    $('#eventModal').find('#saveEventBtn').show();
                    $('#eventModal').find('#showEventBtn').hide(); // Hide the Show button initially
                    $('#eventModal').modal('show');
                },
                eventClick: function(event) {
                    // Adjust end date for display and form inputs
                    var adjustedEnd = moment(event.end).subtract(1, 'days');

                    $('#eventModal').find('.modal-title').text('Edit Event');
                    $('#eventModal').find('#eventId').val(event.id);
                    $('#eventModal').find('#eventTitle').val(event.title);
                    $('#eventModal').find('#eventStart').val(event.start.format('YYYY-MM-DD HH:mm:ss'));
                    $('#eventModal').find('#eventEnd').val(adjustedEnd.format('YYYY-MM-DD HH:mm:ss'));
                    $('#eventModal').find('#eventDescription').val(event.description);
                    $('#eventModal').find('#eventRoom').val(event.room);
                    $('#eventModal').find('#eventShirt').val(event.shirt);

                    // Update the Show button URL
                    var adjustedEndForShow = moment(event.end).subtract(1, 'days');
                    $('#eventModal').find('#showEventBtn').attr('href', SITEURL + "/events/" + event
                            .id + "?end=" + adjustedEndForShow.format('YYYY-MM-DD'))
                        .show();

                    $('#eventModal').find('#removeEventBtn').show();
                    $('#eventModal').find('#editEventBtn').show();
                    $('#eventModal').find('#saveEventBtn').hide();
                    $('#eventModal').modal('show');
                },


                viewRender: function(view, element) {
                    checkTodaysEvents();
                },
            });

            function checkTodaysEvents() {
                var today = moment().format('YYYY-MM-DD');
                $.ajax({
                    url: SITEURL + "/events",
                    type: 'GET',
                    data: {
                        start: today,
                        end: today
                    },
                    success: function(data) {
                        var eventsToday = data.filter(event => moment(event.start).format(
                            'YYYY-MM-DD') === today);
                        if (eventsToday.length > 0) {
                            var eventList = '<ul>';
                            eventsToday.forEach(event => {
                                eventList += '<li>' + event.title + ', ' + event.room + '</li>';
                            })
                            eventList += '</ul>';
                            toastr.info('You have events scheduled for today:' + eventList,
                                'Today\'s Events', {
                                    closeButton: true,
                                    enableHtml: true
                                });
                        }
                    },
                    error: function() {
                        toastr.error('Error fetching events.');
                    }
                });
            }

            $('#saveEventBtn').click(function() {
                var formData = {
                    id: $('#eventId').val(),
                    title: $('#eventTitle').val(),
                    start: $('#eventStart').val(),
                    end: moment($('#eventEnd').val()).add(1, 'days').format(
                    'YYYY-MM-DD HH:mm:ss'), // Sesuaikan tanggal akhir
                    description: $('#eventDescription').val(),
                    room: $('#eventRoom').val(),
                    shirt: $('#eventShirt').val(),
                };

                $.ajax({
                    url: SITEURL + "/events",
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#eventModal').modal('hide');
                        toastr.success('Event saved successfully');
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON.message || 'Error saving event';
                        toastr.error(errorMessage);
                    }
                });
            });

            $('#editEventBtn').click(function() {
                var formData = {
                    id: $('#eventId').val(),
                    title: $('#eventTitle').val(),
                    start: $('#eventStart').val(),
                    end: moment($('#eventEnd').val()).add(1, 'days').format(
                    'YYYY-MM-DD HH:mm:ss'), // Sesuaikan tanggal akhir
                    description: $('#eventDescription').val(),
                    room: $('#eventRoom').val(),
                    shirt: $('#eventShirt').val(),
                };
                $.ajax({
                    url: SITEURL + "/events/" + $('#eventId').val(),
                    type: 'PUT',
                    data: formData,
                    success: function(data) {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#eventModal').modal('hide');
                        toastr.success('Event updated successfully');
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON.message || 'Error updating event';
                        toastr.error(errorMessage);
                    }
                });
            });

            $('#removeEventBtn').click(function() {
                var id = $('#eventId').val();
                $.ajax({
                    url: SITEURL + "/events/" + id,
                    type: 'DELETE',
                    success: function(data) {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#eventModal').modal('hide');
                        toastr.success('Event deleted successfully');
                    },
                    error: function() {
                        location.reload();
                        toastr.success('Event deleted successfully');
                    }
                });
            });

            function saveEvent(event) {
                var formData = {
                    id: event.id,
                    title: event.title,
                    start: event.start.format('YYYY-MM-DD HH:mm:ss'),
                    end: event.end.subtract(1, 'days').format(
                        'YYYY-MM-DD HH:mm:ss'), // Pastikan pengurangan satu hari
                    description: event.description,
                    room: event.room,
                    shirt: event.shirt,
                };
                $.ajax({
                    url: SITEURL + "/events/" + event.id, // Gunakan PUT method untuk update
                    type: 'PUT',
                    data: formData,
                    success: function(data) {
                        toastr.success('Event updated successfully');
                    },
                    error: function() {
                        toastr.error('Error updating event');
                        location.reload();
                    }
                });
            }
        });
    </script>

</body>

</html>
