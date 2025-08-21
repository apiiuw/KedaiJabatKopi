<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Calistoga&display=swap" rel="stylesheet"> --}}
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f9f9f9;
            padding: 20px;
            color: #333;
        }
        .header {
            background-color: #2E6342;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            font-family: 'Dancing Script', 'Cursive', sans-serif;
            margin: 0;
        }
        .info-box {
            background-color: white;
            padding: 15px 20px;
            border-left: 4px solid #2E6342;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            color: #333;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="https://raw.githubusercontent.com/apiiuw/KedaiJabatKopi/main/public/img/icon/icon.png" alt="Jabat Kopi Logo">
        <h2>Kedai Jabat Kopi</h2>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <p><strong>Hello, {{ $order->name }}! 🍃</strong></p>

        <strong>Order ID:</strong> {{ $order->id_order }}<br> 
        @if ($order->order_type == 'Takeaway')
            <strong>Order Type:</strong> {{ ucwords($order->order_type) }}<br>
        @else
            <strong>Order Type:</strong> {{ ucwords($order->order_type) }}<br>
            <strong>Table Number:</strong> {{ $order->table_number ?? '-' }}<br>
        @endif
        <strong>Status Order:</strong> {{ ucwords($order->status) }}<br>

        @if ($order->status === 'on going')
            <p>Your special order is now being prepared with care. Please wait a moment while we make it perfect for you ☕.</p>
        @elseif ($order->status === 'complete')
            <p>We're happy to let you know your order is ready and completed. Enjoy your drink, and we hope to see you again soon 🥰.</p>
        @else
            <p>We've received your order and will update you once it's being prepared. 🍃</p>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        This message was sent by <strong>Kedai Jabat Kopi</strong> - brewed with love ❤️
    </div>

</body>
</html>
