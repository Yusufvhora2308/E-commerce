@extends('layouts.user')

@section('title', 'Your Orders')

@section('content')

<div class="container py-4">

    <h3 class="mb-4">Confirmed Orders</h3>

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Order Id {{ $order->id }} ({{ $order->created_at->format('d M, Y') }})</span>
                    <span>
                        @switch($order->status)
                            @case('Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @break
                            @case('Accepted')
                                <span class="badge bg-primary">Accepted</span>
                                @break
                            @case('Delivered')
                                <span class="badge bg-success">Delivered</span>
                                                      <a href="{{ route('admin.order.billPDF', $order->id) }}" 
   class="btn btn-danger btn-sm">
    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
</a>
                                @break
                            @case('Cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Unknown</span>
                        @endswitch


                    </span>
                </div>

                <div class="card-body border-bottom">
    <p class="mb-1">
        <strong>Payment Method:</strong>
        {{ ucfirst($order->payment_method ?? 'N/A') }}
    </p>

    <p class="mb-1">
        <strong>Payment ID:</strong>
        {{ $order->payment_id ?? 'N/A' }}
    </p>

    <p class="mb-0">
        <strong>Payment Status:</strong>
        <span class="badge 
            {{ $order->payment_status == 'paid' || $order->payment_status == 'success'
                ? 'bg-success'
                : 'bg-warning text-dark' }}">
            {{ ucfirst($order->payment_status) }}
        </span>
    </p>
</div>


                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $itemsTotal = 0; @endphp
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->price,2) }}</td>
                                        <td>₹{{ number_format($item->total,2) }}</td>
                                    </tr>
                                    @php $itemsTotal += $item->total; @endphp
                                @endforeach

                                {{-- SHIPPING --}}
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping Charge</td>
                                    <td>₹{{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                                </tr>

                                {{-- TOTAL --}}
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td>₹{{ number_format($itemsTotal + ($order->shipping_cost ?? 0), 2) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-secondary">You have no confirmed orders yet.</p>
    @endif

</div>

@endsection
