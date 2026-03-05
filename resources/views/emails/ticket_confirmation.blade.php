<!DOCTYPE html>
<html>

<head>
    <title>Ticket Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }

        .email-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        .details {
            margin-top: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .highlight {
            font-weight: bold;
            color: #000;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Hello {{ $userName }} 🎉</h2>
        <p>Your ticket for <span class="highlight">{{ $eventTitle }}</span> is confirmed!</p>

        <div class="details">
            <p><span class="highlight">Ticket ID:</span> {{ $ticketId }}</p>
            <p><span class="highlight">Quantity:</span> {{ $quantity }}</p>
            <p><span class="highlight">Total Price:</span> ₹{{ number_format($totalPrice, 2) }}</p>
            <p><span class="highlight">Description:</span> {{ $description }}</p>
            <p><span class="highlight">Venue:</span> {{ $venue }}</p>
            <p><span class="highlight">Date & Time:</span>
                {{ \Carbon\Carbon::parse($eventDateTime)->format('d M Y, h:i A') }}</p>

        </div>

        <p>Thank you for booking with us! We look forward to seeing you there. 🎶</p>

        <div class="footer">
            &copy; {{ date('Y') }} Event Ticketing. All rights reserved.
        </div>
    </div>
</body>

</html>
