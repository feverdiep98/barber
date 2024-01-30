<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f8f8;
        }

        h1 {
            color: #4285f4;
        }

        p {
            margin-bottom: 15px;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4285f4;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Confirmed</h1>
        <p>Dear {{ $booking->name }}</p>
        <p>Your booking has been confirmed. Here are the details:</p>
        <p><strong>ID:</strong> {{ $booking->id }}</p>
        <p><strong>Email:</strong> {{ $booking->email }}</p>
        <p><strong>Phone Number:</strong> {{ $booking->phone }}</p>
        <!-- Include booking details here -->
        <p><strong>Booking Date:</strong> {{ $booking->booking_date }}</p>
        <p><strong>Booking Time:</strong> {{ $booking->booking_time }}</p>
        <p><strong>Service Type:</strong> {{ $booking->type }}</p>
        <p><strong>People:</strong> {{ $booking->slot }}</p>
        <p>Thank you for choosing our service!</p>

        <p>Best regards,<br>
        The HairCut Barber</p>

        <a class="cta-button" href="{{ route('home') }}" target="_blank">Visit Our Website</a>
    </div>
</body>
</html>
