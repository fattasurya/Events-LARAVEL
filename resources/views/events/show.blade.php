<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <link rel="icon" type="image/png" href="https://png.pngtree.com/png-clipart/20240416/original/pngtree-hanging-calendar-illustration-png-image_14839196.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #00bcd4, #009688);
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #00acc1;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 10px;
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

        .back-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $event->title }}</h1>
        <div class="event-details">
            <p><strong>Mulai:</strong> {{ $event->start }}</p>
            <p><strong>Selesai:</strong> {{ \Carbon\Carbon::parse($event->end)->subDay()->format('Y-m-d H:i:s') }}</p> <!-- Subtract one day -->
            <p><strong>Deskripsi:</strong> {{ $event->description }}</p>
            <p><strong>Ruangan:</strong> {{ $event->room }}</p>
            <p><strong>Baju:</strong> {{ $event->shirt }}</p>
        </div>
        <div class="back-btn">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>

</html>
