@extends('layouts.app')

@section('title', 'Edit Shipping Charge')

@section('content')

<style>
    .shipping-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .shipping-card:hover {
        transform: scale(1.01);
    }
</style>

<div class="container mt-5" style="max-width: 600px;">

    <div class="shipping-card">

        <h3 class="fw-bold mb-4">Edit Shipping Charge</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('shipping.update', $charge->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Shipping Charge (₹)</label>
                <input type="number" step="0.01" name="charge_amount" class="form-control"
                       value="{{ $charge->charge_amount }}" required>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('shipping.index') }}" class="btn btn-secondary">Back</a>
        </form>

    </div>

</div>

@endsection
    