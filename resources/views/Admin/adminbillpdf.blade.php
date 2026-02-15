<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .title { font-size: 22px; font-weight: bold; color: #333; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td {
            border: 1px solid #555;
            padding: 6px;
            text-align: center;
        }
        table th { background: #222; color: #fff; }
        .right { text-align: right; }
    </style>
</head>
<body>

<h2 class="title">Invoice #{{ $order->id }}</h2>

<div class="section">
    <strong>Customer:</strong> {{ $order->first_name }} {{ $order->last_name }} <br>
    <strong>Email:</strong> {{ $order->user->email }} <br>
    <strong>Address:</strong>
    {{ $order->address }}, {{ $order->city }},
    {{ $order->state }} - {{ $order->zip }} <br>

    <strong>Date:</strong> {{ $order->created_at->format('d M, Y') }} <br>

    <strong>Payment ID:</strong> {{ $order->payment_id ?? 'N/A' }} <br>
    <strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }} <br>
    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status ?? 'N/A') }} <br>
    <strong>Order Status:</strong> {{ $order->status }}
</div>


<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Price (₹)</th>
            <th>Qty</th>
            <th>Total (₹)</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ number_format($item->price,2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->total,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="section right">
    <h4>Subtotal: ₹{{ number_format($order->subtotal,2) }}</h4>
    <h4>Shipping: ₹{{ number_format($order->shipping_cost,2) }}</h4>
    <h2>Total: ₹{{ number_format($order->total,2) }}</h2>
</div>

</body>
</html>
