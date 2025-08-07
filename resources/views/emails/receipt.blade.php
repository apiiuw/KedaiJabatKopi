<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Calistoga&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Amiri', serif;
            background-color: #f9f9f9;
            padding: 20px;
            color: #333;
            font-size: clamp(14px, 2vw, 16px);
        }

        .header {
            background-color: #2E6342;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .header h2 {
            font-family: 'Calistoga', cursive;
            font-size: clamp(20px, 3vw, 28px);
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
        }

        .info-box strong {
            display: block;
            margin-bottom: 4px;
        }

        .receipt-container {
            background-color: white;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .receipt-header {
            text-align: center;
            font-weight: bold;
            font-size: clamp(18px, 3vw, 24px);
            margin-bottom: 20px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: clamp(12px, 2vw, 14px);
        }

        .receipt-table th, .receipt-table td {
            border-bottom: 1px dashed #ccc;
            padding: 8px;
            text-align: right;
        }

        .receipt-table th:first-child,
        .receipt-table td:first-child {
            text-align: left;
        }

        .receipt-description {
            font-size: 12px;
            font-style: italic;
            color: #777;
            margin-top: 4px;
        }

        .description-mobile {
            display: none;
        }

        .description-desktop {
            display: block;
        }

        @media only screen and (max-width: 600px) {
            .description-mobile {
                display: table-row;
            }

            .description-desktop {
                display: none;
            }
        }

        .receipt-total {
            font-weight: bold;
            font-size: clamp(14px, 2.5vw, 16px);
            display: flex;
            justify-content: space-between;
        }

        .receipt-footer {
            text-align: center;
            font-size: clamp(10px, 2vw, 12px);
            margin-top: 20px;
            color: #888;
        }

        .corner {
            position: absolute;
            background-color: #f3f3f3;
            box-shadow: inset 0 0 4px rgba(0,0,0,0.1);
        }

        .corner.top-left {
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }

        .corner.bottom-right {
            bottom: 0;
            right: 0;
            width: 20px;
            height: 20px;
            clip-path: polygon(100% 0, 0 0, 0 100%);
        }

        .motivational-text {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 15px;
            font-style: italic;
            text-align: center;
            font-size: clamp(12px, 2vw, 14px);
            color: #444;
            border-left: 3px solid #2E6342;
        }

        .footer {
            max-width: 600px;
            margin: 40px auto 0;
            font-size: clamp(10px, 2vw, 12px);
            text-align: center;
            color: #aaa;
            border-top: 1px solid #ddd;
            padding-top: 10px;
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
        <strong>Order ID:</strong> {{ $order->id_order }}
        <strong>Table Number:</strong> {{ $order->table_number }}
        <p>Your order has been successfully received and is being processed ☕</p>
    </div>

    <!-- Receipt -->
    <div class="receipt-container" style="font-family: monospace;">
        <div class="corner top-left"></div>
        <div class="corner bottom-right"></div>

        <div class="receipt-header">Your Receipt</div>

        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->menu->product_name }}
                            <div class="description-desktop">
                                @if ($item->description)
                                    <div class="receipt-description">{{ $item->description }}</div>
                                @endif
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    </tr>

                    {{-- Baris terpisah hanya untuk mobile --}}
                    @if ($item->description)
                        <tr class="description-mobile">
                            <td colspan="4" class="receipt-description">{{ $item->description }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div class="receipt-total">
            <span>Amount</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>

        <div class="receipt-footer">
            Thank you for sipping happiness with Jabat Kopi ☕
        </div>
    </div>

    <!-- Motivational Text -->
    <div class="motivational-text">
        Life is better with coffee in hand. Stay warm, stay kind, and keep going ✨
    </div>

    <!-- Footer -->
    <div class="footer">
        This message was sent by <strong>Kedai Jabat Kopi</strong> – brewed with love ❤️
    </div>
</body>
</html>
