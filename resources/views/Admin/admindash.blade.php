@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')

<style>
    .dashboard-container { padding: 25px; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stats-card {
        background: #fff;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.07);
        transition: .3s;
    }

    .stats-card:hover { transform: translateY(-4px); }

    .stats-icon {
        font-size: 35px;
        color: #4a6cf7;
        margin-bottom: 10px;
    }

    .recent-order-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
</style>

<div class="container-fluid dashboard-container">

    <!-- Stats Section -->
    <h3 class="fw-bold mb-4">Dashboard Overview</h3>

    <div class="stats-grid">

        <div class="stats-card">
            <i class="fa-solid fa-bag-shopping stats-icon"></i>
            <p class="text-muted mb-1">Total Orders</p>
            <h4>{{ $totalOrders }}</h4>
        </div>


         <div class="stats-card">
            <i class="fa-solid fa-box-open stats-icon"></i>
            <p class="text-muted mb-1">Total Products</p>
            <h4>{{ $totalProducts }}</h4>
        </div>

         <div class="stats-card">
            <i class="fa-solid fa-layer-group stats-icon"></i>
            <p class="text-muted mb-1">Total Categories</p>
            <h4>{{ $totalCategories }}</h4>
        </div>       

        <div class="stats-card">
            <i class="fa-solid fa-industry stats-icon"></i>
            <p class="text-muted mb-1">Total Brands</p>
            <h4>{{ $totalBrands }}</h4>
        </div>


        <div class="stats-card">
            <i class="fa-solid fa-check-circle stats-icon text-success"></i>
            <p class="text-muted mb-1">Delivered Orders</p>
            <h4>{{ $deliveredOrders }}</h4>
        </div>

         <div class="stats-card">
            <i class="fa-solid fa-clock stats-icon text-warning"></i>
            <p class="text-muted mb-1">Pending Orders</p>
            <h4>{{ $pendingOrders }}</h4>
        </div>

        <div class="stats-card">
            <i class="fa-solid fa-indian-rupee-sign stats-icon"></i>
            <p class="text-muted mb-1">Total Revenue</p>
            <h4>₹{{ number_format($totalAmount, 2) }}</h4>
        </div>

        <div class="stats-card">
            <i class="fa-solid fa-check stats-icon text-success"></i>
            <p class="text-muted mb-1">Delivered Revenue</p>
            <h4>₹{{ number_format($deliveredAmount, 2) }}</h4>
        </div>

    </div>

    <!-- Recent Orders -->
    <div class="recent-order-box mt-5">
        <h4 class="fw-bold mb-3">Recent Orders</h4>

        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Items</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td>₹{{ number_format($order->subtotal, 2) }}</td>
                        <td>₹{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($order->status == 'Delivered') bg-success 
                                @elseif($order->status == 'Pending') bg-warning 
                                @else bg-info @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>    {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}
</td>
                        <td>{{ $order->items->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($recentOrders->count() == 0)
            <p class="text-center text-muted">No recent orders found.</p>
        @endif
    </div>

</div>

@endsection
