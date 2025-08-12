<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Report PDF</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            color: #333; 
            margin: 10px 15px 15px 15px; /* kurang padding atas dan kanan kiri */
            font-size: 12px; /* text keseluruhan lebih kecil */
        }
        h1 { 
            color: #333; 
            margin-bottom: 5px; 
            font-size: 18px; 
            font-weight: bold;
            text-align: center; /* tengah */
        }
        .print-date {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-bottom: 3px;
            font-style: italic;
        }
        .period-date {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-bottom: 20px;
            font-style: italic;
        }
        h2 { 
            color: #333; 
            margin-top: 30px; 
            margin-bottom: 10px; 
            font-size: 14px;
            font-weight: bold;
        }

        /* Summary table */
        table.summary-table {
            margin-bottom: 20px;
            border: none;
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px; /* beri jarak antar kotak */
        }
        table.summary-table td {
            background-color: #2E6342;
            color: white;
            font-weight: bold;
            font-size: 14px; /* text summary lebih kecil */
            border-radius: 6px;
            padding: 12px 8px; /* padding lebih kecil */
            text-align: center;
            vertical-align: middle;
            border: none;
            width: 23%; /* 4 kotak sama lebar dengan jarak */
        }
        table.summary-table td.expense {
            background-color: #a03a3a;
        }
        .summary-label {
            font-size: 10px;
            margin-bottom: 6px;
        }
        .summary-value {
            font-size: 20px;
            line-height: 1.2;
        }
        .summary-value-best-seller {
            font-size: 12px;
            line-height: 1.2;
        }

        /* General tables */
        table {
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            font-size: 11px; /* font tabel lebih kecil */
        }
        th, td {
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
            border: 1px solid #4a7a4a; /* border lebih gelap tapi soft */
        }
        th {
            background-color: #cdeac0;
            font-weight: bold;
        }

        /* Expenses table warna merah */
        table.expenses thead th,
        table.expenses tbody td {
            border-color: #a03a3a;
        }
        table.expenses thead th {
            background-color: #f7c6c6;
            color: #7a1a1a;
        }
    </style>
</head>
<body>
    <h1>Report Kedai Jabat Kopi</h1>
    <div class="print-date">Print Date: {{ $printDate }}</div>
    <div class="period-date">Period: {{ $period }}</div>

    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Incomes</div>
                <div class="summary-value">{{ $totalIncomes }}</div>
            </td>
            <td class="expense">
                <div class="summary-label">Total Expenses</div>
                <div class="summary-value">{{ $totalExpenses }}</div>
            </td>
            <td>
                <div class="summary-label">Total Orders</div>
                <div class="summary-value">{{ $totalOrders }}</div>
            </td>
            <td>
                <div class="summary-label">Best Seller</div>
                <div class="summary-value-best-seller">{{ $bestSeller }}</div>
            </td>
        </tr>
    </table>

    <h2>Incomes Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Date</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($incomes->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center; font-style: italic; color: #666;">
                        No data found.
                    </td>
                </tr>
            @else
                @foreach($incomes as $order)
                <tr>
                    <td>#{{ $order->id_order }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->menu->product_name ?? 'Unknown' }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->menu->category ?? 'Unknown' }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->menu->type ?? 'Unknown' }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->quantity }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            Rp {{ number_format($item->price, 0, ',', '.') }}<br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h2>Expenses Report</h2>
    <table class="expenses">
        <thead>
            <tr>
                <th>ID Expense</th>
                <th>Date</th>
                <th>Category</th>
                <th>Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($expenses->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center; font-style: italic; color: #666;">
                        No data found.
                    </td>
                </tr>
            @else
                @foreach($expenses as $expense)
                <tr>
                    <td>#{{ $expense->id_expenses }}</td>
                    <td>{{ $expense->created_at->format('d/m/Y') }}</td>
                    <td>{{ $expense->category ?? 'Unknown' }}</td>
                    <td>{{ $expense->item }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->qty }}</td>
                    <td>Rp {{ number_format($expense->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($expense->qty * $expense->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
