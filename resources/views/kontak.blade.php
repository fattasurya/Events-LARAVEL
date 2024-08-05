<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
    <link rel="icon" type="image/png" href="https://png.pngtree.com/png-clipart/20240416/original/pngtree-hanging-calendar-illustration-png-image_14839196.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #00bcd4, #009688);
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333333;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            border: 1px solid #00acc1;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.4);
        }

        .container:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(151, 198, 204, 0.1), rgba(205, 228, 231, 0.3));
            border-radius: 15px;
            z-index: 0;
            transform: scale(1.1);
            transition: transform 0.3s;
        }

        .container:hover:before {
            transform: scale(1);
        }

        .contact-info {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .contact-info h1 {
            font-size: 2.2rem;
            color: #00acc1;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .contact-info p {
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-info .icon {
            margin-right: 15px;
            color: #00acc1;
            font-size: 1.6rem;
        }

        .contact-info a {
            color: #00acc1;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-info a:hover {
            text-decoration: underline;
            color: #4dccbf;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #00acc1;
            color: #ffffff;
        }

        .btn-secondary {
            background-color: #cdf4f9;
            border: none;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-secondary:hover {
            background-color: #c9ebee;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="contact-info">
            <h1>Contact Us</h1>
            <p><i class="fas fa-envelope icon"></i><strong>Email:</strong> <a href="mailto:fatta.surya@gmail.com">fatta.surya@gmail.com</a></p>
            <p><i class="fas fa-phone-alt icon"></i><strong>Number:</strong> +62-6545-6556-</p>
            <p><i class="fab fa-instagram icon"></i><strong>Instagram:</strong> @fattasuryaa</p>
            <p><i class="fas fa-map-marker-alt icon"></i><strong>Address:</strong> JL GUNUK RAYA</p>
            <a href="{{ url('/') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
