@extends('layouts.app')

@section('title', 'Shipping Charge')

@section('content')

<style>
    .shipping-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0,0,0,0.1);
    }

    .table thead th {
        background: #212529;
        color: white;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .table tbody tr:hover {
        background: #f8f9fa !important;
        transition: 0.2s;
    }

    .page-title {
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 20px;
    }

</style>

<div class="container mt-4">

    <h3 class="page-title">Shipping Charges</h3>

    <div class="shipping-table mt-3">

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Charge Amount (₹)</th>
                    <th width="120px">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($charges as $charge)
                <tr>
                  <td>{{ ($charges->currentPage() - 1) * $charges->perPage() + $loop->iteration }}</td>

                    <td><strong>₹ {{ $charge->charge_amount }}</strong></td>


                    <td>
                        <a href="{{ route('shipping.edit', $charge->id) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $charges->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
