@extends('layouts.app')

@section('title','Order Details')

@section('content')

<div class="container mt-4">

<!-- Search + Filter -->
<form action="{{ route('admin.orders') }}" method="GET" class="mb-4">
    <div class="row g-2">

        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control" placeholder="Search name/order ID">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Orders</option>
                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                <option value="Accepted" {{ request('status')=='Accepted'?'selected':'' }}>Accepted</option>
                <option value="Delivered" {{ request('status')=='Delivered'?'selected':'' }}>Delivered</option>
                <option value="Cancelled" {{ request('status')=='Cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary w-100">Reset</a>
        </div>

    </div>
</form>



<h2 class="fw-bold mb-4 text-primary">Order Management</h2>

<div class="card shadow-lg border-0">
    <div class="card-body">

        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Bill</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                <tr>
                 <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>

                    <td>
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong>
                        
                    </td>

                    <td class="fw-bold">₹ {{ number_format($order->total,2) }}</td>

                    <td>
                        @if($order->status=='Pending')
                            <span class="badge bg-warning text-dark">Pending</span>

                        @elseif($order->status=='Accepted')
                            <span class="badge bg-info text-dark">Accepted</span>

                        @elseif($order->status=='Delivered')
                            <span class="badge bg-success">Delivered</span>

                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>

<td>
    {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}
</td>


               <td>
   <a href="{{ route('admin.order.bill', $order->id) }}" 
   class="btn btn-dark btn-sm mb-1">
    <i class="bi bi-eye-fill"></i> View Bill
</a>

<a href="{{ route('admin.order.billPDF', $order->id) }}" 
   class="btn btn-danger btn-sm">
    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
</a>

</td>



                    <td>

                        @if($order->status=='Pending')
                            <a href="{{ route('admin.order.accept',$order->id) }}" class="btn btn-primary btn-sm">Accept</a>
                            <a href="{{ route('admin.order.cancel',$order->id) }}" class="btn btn-danger btn-sm">Cancel</a>

                        @elseif($order->status=='Accepted')
                            <a href="{{ route('admin.order.deliver',$order->id) }}" class="btn btn-success btn-sm">Delivered</a>

                        @elseif($order->status=='Delivered')
                            <button class="btn btn-success btn-sm" disabled>Delivered</button>

                        @else
                            <button class="btn btn-danger btn-sm" disabled>Cancelled</button>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

       <div class="d-flex justify-content-center mt-3">
    {{ $orders->links('pagination::bootstrap-5') }}
</div>


    </div>
</div>

</div>

@endsection
