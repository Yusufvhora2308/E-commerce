@extends('layouts.user')

@section('title','Order Bill')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Order Bill #{{ $order->id }}</h1>

    {{-- ================= BILLING DETAILS ================= --}}
    <div class="card shadow-sm rounded-0">
        <div class="card-header bg-dark text-white fw-bold">Billing Details</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
            <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</p>
            <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }} (₹{{ number_format($order->shipping_cost,2) }})</p>

            {{-- Payment Details --}}
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Payment ID:</strong> {{ $order->payment_id }}</p>
            <p><strong>Payment Status:</strong>
               <span class="badge 
            {{ $order->payment_status == 'paid' || $order->payment_status == 'success'
                ? 'bg-success'
                : 'bg-warning text-dark' }}">
            {{ ucfirst($order->payment_status) }}
        </span>
            </p>
        </div>
    </div>

    {{-- ================= ORDER ITEMS ================= --}}
    <div class="card shadow-sm rounded-0 mt-4">
        <div class="card-header bg-dark text-white fw-bold">Order Items</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
                        <span>₹{{ number_format($item->total,2) }}</span>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between fw-bold">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal,2) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between fw-bold">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_cost,2) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between fw-bold h5">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total,2) }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'Order Successful 🎉',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#111',
        confirmButtonText: 'OK'
    });
});
</script>
@endif
@endpush

@endsection
