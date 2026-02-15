@extends('layouts.user')

@section('title','User Cart')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4">Your Cart</h2>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carts as $cart)
                <tr>
                    @if($cart->product)
                        {{-- PRODUCT --}}
     <td class="d-flex align-items-center gap-3 text-start">
    @php
        $image = $cart->product?->images->first();
    @endphp

    <img src="{{ asset($image ? 'uploads/products/'.$image->image : 'images/no-image.png') }}"
         width="60" height="60" class="rounded border">

    <span class="fw-semibold">{{ $cart->product->name }}</span>
</td>



                        {{-- PRICE --}}
                        <td>₹{{ number_format($cart->product->price, 2) }}</td>

                        {{-- QTY --}}
                        <td style="width:170px">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button class="btn btn-outline-dark btn-sm qty-decrement"
                                        data-id="{{ $cart->id }}"
                                        @disabled($cart->quantity == 1)>
                                    <i class="bi bi-dash-lg"></i>
                                </button>

                                <span class="fw-bold" id="qty-{{ $cart->id }}">
                                    {{ $cart->quantity }}
                                </span>

                                <button class="btn btn-outline-dark btn-sm qty-increment"
                                        data-id="{{ $cart->id }}"
                                        data-stock="{{ $cart->product->stock }}"
                                        @disabled($cart->quantity >= $cart->product->stock)>
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>

                            <small class="text-muted">
                                Stock: {{ $cart->product->stock }}
                            </small>
                        </td>

                        {{-- TOTAL --}}
                        <td id="total-{{ $cart->id }}">
                            ₹{{ number_format($cart->product->price * $cart->quantity, 2) }}
                        </td>

                    @else
                        <td colspan="4">
                            <span class="text-danger fw-bold">
                                Product not available
                            </span>
                        </td>
                    @endif

                    {{-- ACTION --}}
                    <td>
                        <button class="btn btn-danger btn-sm remove-cart"
                                data-id="{{ $cart->id }}">
                            Remove
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
{{-- CHECKOUT --}}
<div class="text-end mt-4">
    @if($carts->count() > 0)
        <a href="{{ route('checkout') }}" 
           class="btn btn-dark btn-lg">
            Proceed to Checkout
        </a>
    @else
        <button class="btn btn-secondary btn-lg" disabled>
            Cart is Empty
        </button>
    @endif
</div>


</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const routes = {
        increment: "{{ route('cart.increment', ':id') }}",
        decrement: "{{ route('cart.decrement', ':id') }}",
        remove: "{{ route('cart.remove', ':id') }}"
    };

    document.addEventListener('click', function(e){

        // INCREMENT
        let incBtn = e.target.closest('.qty-increment');
        if(incBtn){
            let id = incBtn.dataset.id;

            fetch(routes.increment.replace(':id', id), {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept':'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    document.getElementById(`qty-${id}`).innerText = res.qty;
                    document.getElementById(`total-${id}`).innerText = `₹${res.total}`;

                    if(res.qty >= parseInt(incBtn.dataset.stock)){
                        incBtn.disabled = true;
                    }

                    document.querySelector(`.qty-decrement[data-id='${id}']`).disabled = false;
                }
            });
        }

        // DECREMENT
        let decBtn = e.target.closest('.qty-decrement');
        if(decBtn){
            let id = decBtn.dataset.id;

            fetch(routes.decrement.replace(':id', id), {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept':'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    document.getElementById(`qty-${id}`).innerText = res.qty;
                    document.getElementById(`total-${id}`).innerText = `₹${res.total}`;

                    decBtn.disabled = res.qty <= 1;
                    document.querySelector(`.qty-increment[data-id='${id}']`).disabled = false;
                }
            });
        }

        // REMOVE
        let rmBtn = e.target.closest('.remove-cart');
        if(rmBtn){
            let id = rmBtn.dataset.id;

            fetch(routes.remove.replace(':id', id), {
                method:'DELETE',
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept':'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    rmBtn.closest('tr').remove();
                }
            });
        }

    });

});
</script>
@endpush
