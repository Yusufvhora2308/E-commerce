@extends('layouts.app')

@section('title','Invoice')

@section('content')

<style>
    .invoice-card {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }
    .invoice-header {
        border-bottom: 2px solid #e6e6e6;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>

<div class="container mt-4">

    <div class="invoice-card">

        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary">Invoice #{{ $order->id }}</h2>

            <div>
                <a href="{{ route('admin.order.billPDF',$order->id) }}" 
                   class="btn btn-danger btn-sm">Download PDF</a>

                <a href="{{ route('admin.orders') }}" 
                   class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>

        <!-- Customer + Order Info -->
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold">Customer Information</h5>
                <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
            </div>

          <div class="col-md-6 text-end">
    <h5 class="fw-bold">Order Details</h5>

    <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>

    <p><strong>Payment ID:</strong> {{ $order->payment_id ?? 'N/A' }}</p>

    <p><strong>Payment Method:</strong>
        {{ ucfirst($order->payment_method ?? 'N/A') }}
    </p>

    <p>
        <strong>Payment Status:</strong>
        <span class="badge 
            {{ $order->payment_status == 'paid' || $order->payment_status == 'success'
                ? 'bg-success'
                : 'bg-warning text-dark' }}">
            {{ ucfirst($order->payment_status) }}
        </span>
    </p>

    @php
        $badge = [
            'Pending' => 'warning text-dark',
            'Accepted' => 'info text-dark',
            'Delivered' => 'success',
            'Cancelled' => 'danger'
        ];
    @endphp

    <p>
        <strong>Order Status:</strong>
        <span class="badge bg-{{ $badge[$order->status] }}">
            {{ $order->status }}
        </span>
    </p>
</div>

        <hr>

        <!-- Item Table -->
        <h5 class="fw-bold mb-3">Order Items</h5>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>₹{{ number_format($item->price,2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->total,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <div class="text-end">
            <h5>Subtotal: ₹{{ number_format($order->subtotal, 2) }}</h5>
            <h5>Shipping Charge: ₹{{ number_format($order->shipping_cost, 2) }}</h5>
            <h3 class="fw-bold text-success">Grand Total: ₹{{ number_format($order->total, 2) }}</h3>
        </div>

        <hr>

        <p class="text-center text-muted mb-0">
            Thank you for shopping with us!
        </p>
    </div>

</div>

@endsection
