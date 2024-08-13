<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event List</title>
    <link rel="icon" type="image/png" href="https://png.pngtree.com/png-clipart/20240416/original/pngtree-hanging-calendar-illustration-png-image_14839196.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #00bcd4, #009688);
            overflow: hidden;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            height: 600px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease-in-out;
        }

        .container:hover {
            transform: scale(1.03);
        }

        h1 {
            color: #00acc1;
            margin-bottom: 30px;
        }

        .btn {
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: #00acc1;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #00838f;
        }

        .btn-primary {
            background-color: #00acc1;
            border: none;
        }

        .btn-primary:hover {
            background-color: #00838f;
        }

        .btn-danger {
            background-color: #e53935;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c62828;
        }

        .btn-small {
            font-size: 0.8rem; /* Adjust as needed */
            padding: 0.25rem 0.5rem; /* Adjust padding to make the button smaller */
        }

        .table-container {
            max-height: 325px; /* Adjust the height as needed */
            overflow-y: auto;
            position: relative;
        }

        .table-scroll {
            width: 100%;
            border-collapse: collapse;
        }

        .table-scroll thead th {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            background-color: #00acc1;
            color: #ffffff;
            z-index: 1; /* Ensure the header stays above the scrolling content */
        }

        .table-scroll tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-scroll tbody td {
            position: relative; /* Ensure actions are properly contained within table cells */
        }

        .input-group-append .btn {
            border-radius: 0 8px 8px 0;
        }

        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }

        .pad {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Event List</h1>
        <a href="{{ url('/user') }}" class="btn btn-secondary pad">Back</a>
        <form method="GET" action="{{ route('events.search') }}" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Cari..." value="{{ request()->query('query') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div class="table-container">
            <table class="table table-striped table-scroll">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Room</th>
                        <th>Shirt</th>
                        <th>Event Start</th>
                        <th>Event End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->room }}</td>
                            <td>{{ $event->shirt }}</td>
                            <td>{{ $event->start }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->end)->subDay()->format('Y-m-d H:i:s') }}</td> <!-- Subtract one day -->
                            <td>
                        
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada agenda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
